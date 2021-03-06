const search = document.querySelector('input[placeholder="search for games"]');
const gamesContainer = document.querySelector('.content-wrapper');



search.addEventListener('keyup',function (event)
{
    if(event.key !== "Enter")
        return;


    event.preventDefault();
    const data = {search: this.value};

    fetch("/search",{
        method:'POST',
        headers:
            {
                'Content-Type':'application/json'
            },
        body: JSON.stringify(data)

    }).then(function (response)
        {
            return response.json();
        }
    ).then(function (games)
        {
            gamesContainer.innerHTML = "";
            loadGames(games);
        });

});


function loadGames(games)
{
    games.forEach(game => {
        console.log(game);
        createGame(game);
    });
}


function createGame(game)
{
    const template = document.querySelector("#game-template")
    const clone = template.content.cloneNode(true);

    const link = clone.querySelector("a");
    link.href = `gamePage?title=${game.title}&id_game=${game.id_game}`;

    if(game.image !== null) {
        const image = clone.querySelector("a img");
        image.src = `/public/uploads/${game.image}`;
        image.alt = `${game.title}`;
    }
    else
    {
        link.innerText = game.title;
    }

/*    const attribute = clone.querySelector('.attribute-name');
    if(game.attributes !== null && )
        attribute.innerHTML = game.attributes[0];*/

    gamesContainer.appendChild(clone);


}
