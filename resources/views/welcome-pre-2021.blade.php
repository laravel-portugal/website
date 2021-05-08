
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Website da Comunidade Portguesa de Laravel (Laravel Portugal)">
    <meta name="author" content="Membros da Comunidade Laravel Portugal">

    <title>Laravel Portugal</title>

    <link rel="icon" href="/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Poppins:700,300,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,600,200" rel="stylesheet" type="text/css">

    <link href="/attic/pre-2021.css" rel="stylesheet">
</head>
<body>
<div id="app" class="mx-auto min-h-screen pt-6 relative overflow-hidden">

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 84.1 57.6" class="background mt-20 laravel-logo absolute fill-current text-red-200 opacity-50 mx-auto">
        <path d="M83.8 26.9c-.6-.6-8.3-10.3-9.6-11.9-1.4-1.6-2-1.3-2.9-1.2s-10.6 1.8-11.7 1.9c-1.1.2-1.8.6-1.1 1.6.6.9 7 9.9 8.4 12l-25.5 6.1L21.2 1.5c-.8-1.2-1-1.6-2.8-1.5C16.6.1 2.5 1.3 1.5 1.3c-1 .1-2.1.5-1.1 2.9S17.4 41 17.8 42c.4 1 1.6 2.6 4.3 2 2.8-.7 12.4-3.2 17.7-4.6 2.8 5 8.4 15.2 9.5 16.7 1.4 2 2.4 1.6 4.5 1 1.7-.5 26.2-9.3 27.3-9.8 1.1-.5 1.8-.8 1-1.9-.6-.8-7-9.5-10.4-14 2.3-.6 10.6-2.8 11.5-3.1 1-.3 1.2-.8.6-1.4zm-46.3 9.5c-.3.1-14.6 3.5-15.3 3.7-.8.2-.8.1-.8-.2-.2-.3-17-35.1-17.3-35.5-.2-.4-.2-.8 0-.8S17.6 2.4 18 2.4c.5 0 .4.1.6.4 0 0 18.7 32.3 19 32.8.4.5.2.7-.1.8zm40.2 7.5c.2.4.5.6-.3.8-.7.3-24.1 8.2-24.6 8.4-.5.2-.8.3-1.4-.6s-8.2-14-8.2-14L68.1 32c.6-.2.8-.3 1.2.3.4.7 8.2 11.3 8.4 11.6zm1.6-17.6c-.6.1-9.7 2.4-9.7 2.4l-7.5-10.2c-.2-.3-.4-.6.1-.7.5-.1 9-1.6 9.4-1.7.4-.1.7-.2 1.2.5.5.6 6.9 8.8 7.2 9.1.3.3-.1.5-.7.6z"></path>
    </svg>


    <nav class="flex items-baseline justify-between px-6">


        <h1 class="tracking-normal font-normal text-gray-700 logo">laravel.pt</h1>


        <div class="flex">
            <a href="https://twitter.com/LaravelPortugal" target="_blank" class="text-gray-700 hover:text-blue-400">
                <svg class="fill-current w-5 h-5 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Twitter</title>
                    <path d="M6.29 18.25c7.55 0 11.67-6.25 11.67-11.67v-.53c.8-.59 1.49-1.3 2.04-2.13-.75.33-1.54.55-2.36.65a4.12 4.12 0 0 0 1.8-2.27c-.8.48-1.68.81-2.6 1a4.1 4.1 0 0 0-7 3.74 11.65 11.65 0 0 1-8.45-4.3 4.1 4.1 0 0 0 1.27 5.49C2.01 8.2 1.37 8.03.8 7.7v.05a4.1 4.1 0 0 0 3.3 4.03 4.1 4.1 0 0 1-1.86.07 4.1 4.1 0 0 0 3.83 2.85A8.23 8.23 0 0 1 0 16.4a11.62 11.62 0 0 0 6.29 1.84"></path>
                </svg>        </a>

            <a href="https://laravelportugal.simplecast.fm/" target="_blank" class="text-gray-700 hover:text-blue-400">
                <svg class="fill-current w-5 h-5 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001">
                    <title>Podcast</title>
                    <g><path d="M412.113,170.747c-6.637,0-12.02,5.381-12.02,12.02v75.104c0,79.452-64.639,144.09-144.092,144.09    S111.91,337.321,111.91,257.87v-75.104c0-6.639-5.383-12.02-12.02-12.02c-6.639,0-12.02,5.381-12.02,12.02v75.104    c0,88.666,68.993,161.512,156.111,167.696v62.395h-62.174c-6.637,0-12.02,5.381-12.02,12.02c0,6.639,5.382,12.02,12.02,12.02    h148.386c6.637,0,12.02-5.381,12.02-12.02c0-6.639-5.382-12.02-12.02-12.02H268.02v-62.395    c87.119-6.184,156.111-79.031,156.111-167.696v-75.104C424.133,176.128,418.75,170.747,412.113,170.747z"></path></g>
                    <g><path d="M264.011,0h-16.02c-54.949,0-99.653,44.704-99.653,99.653V265.88c0,54.949,44.704,99.653,99.653,99.653h16.02    c54.949,0,99.653-44.704,99.653-99.653V99.653C363.664,44.704,318.96,0,264.011,0z M339.625,130.853h-43.572    c-6.639,0-12.02,5.381-12.02,12.02c0,6.639,5.381,12.02,12.02,12.02h43.572v33.458h-43.572c-6.639,0-12.02,5.381-12.02,12.02    s5.381,12.02,12.02,12.02h43.572v33.46h-43.572c-6.639,0-12.02,5.381-12.02,12.02s5.381,12.02,12.02,12.02h43.464    c-2.091,39.836-35.157,71.603-75.505,71.603h-16.02c-40.348,0-73.414-31.767-75.505-71.603h43.464    c6.639,0,12.02-5.381,12.02-12.02s-5.381-12.02-12.02-12.02h-43.572v-33.46h43.572c6.639,0,12.02-5.381,12.02-12.02    s-5.381-12.02-12.02-12.02h-43.572v-33.458h43.572c6.639,0,12.02-5.381,12.02-12.02c0-6.639-5.381-12.02-12.02-12.02h-43.572    v-31.2c0-29.964,17.52-55.914,42.854-68.143v33.983c0,6.639,5.382,12.02,12.02,12.02s12.02-5.381,12.02-12.02V24.558    c2.863-0.331,30.595-0.331,33.458,0v40.935c0,6.639,5.381,12.02,12.02,12.02c6.637,0,12.02-5.381,12.02-12.02V31.51    c25.334,12.229,42.854,38.177,42.854,68.142V130.853z"></path></g>
                </svg>        </a>

            <a href="https://github.com/laravel-portugal" target="_blank" class="text-gray-700 hover:text-blue-400">
                <svg class="fill-current w-5 h-5 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>GitHub</title>
                    <path d="M10 0a10 10 0 0 0-3.16 19.49c.5.1.68-.22.68-.48l-.01-1.7c-2.78.6-3.37-1.34-3.37-1.34-.46-1.16-1.11-1.47-1.11-1.47-.9-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.9 1.52 2.34 1.08 2.91.83.1-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.94 0-1.1.39-1.99 1.03-2.69a3.6 3.6 0 0 1 .1-2.64s.84-.27 2.75 1.02a9.58 9.58 0 0 1 5 0c1.91-1.3 2.75-1.02 2.75-1.02.55 1.37.2 2.4.1 2.64.64.7 1.03 1.6 1.03 2.69 0 3.84-2.34 4.68-4.57 4.93.36.31.68.92.68 1.85l-.01 2.75c0 .26.18.58.69.48A10 10 0 0 0 10 0"></path>
                </svg>        </a>

            <a href="https://www.meetup.com/pt-BR/Laravel-Portugal/" target="_blank" class="text-gray-700 hover:text-blue-400">
                <svg viewBox="0 0 512 512" class="fill-current w-5 h-5 mx-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <title>Meetup</title>
                    <path d="m442 114c79 13 30 113 11 152-12 26-72 129-20 145 16 4 36 2 49 13 23 20 2 37-18 42-23 6-51 0-72-10-69-30-53-106-23-157 13-28 38-59 44-82 4-20-16-38-34-17-11 13-20 32-27 47-8 16-48 103-48 103-7 14-20 34-33 45-22 17-57 6-51-23 8-47 81-157 31-164-18-2-24 18-30 31-10 22-16 45-27 67-12 25-22 51-28 78-5 22-12 50-36 56-68 18-89-26-89-26-11-35-1-67 10-101 8-26 13-53 24-78 18-45 37-137 105-131 17 2 36 11 51 19 40 26 54-20 80-25 21-5 33 4 46 14 21 18 27 7 40 5 12-3 29-6 45-3z"></path>
                </svg>
            </a>
        </div>
    </nav>


    <main class="w-full mt-16">
        <h2 class="logo text-gray-700 text-center font-bold text-4xl sm:text-5xl">
            Bem-vindo à comunidade portuguesa de <span class="text-red-500 opacity-75">Laravel</span>
        </h2>

        <div class="flex flex-col md:flex-row mt-20 mb-20">

            <div class="cta">
                <h3 class="text-2xl text-gray-700 font-semibold">
                    LaravelPT Live
                </h3>

                <p class="text-lg text-gray-700 mt-6 flex-1 w-3/4 mx-auto">
                    Os nossos membros discutem tópicos da comunidade, em direto, no Youtube. Todas as sextas-feiras, às 21h00!
                </p>

                <a href="https://www.youtube.com/channel/UCIbMW1h5VReAQAwJGi_zT3w" target="_blank" class="btn bg-blue-500 text-white mx-auto hover:bg-blue-700">
                    <svg viewBox="0 0 100 100" class="fill-current h-8 w-8 mr-2">
                        <path d="M50,3.8C24.5,3.8,3.8,24.5,3.8,50S24.5,96.2,50,96.2S96.2,75.5,96.2,50S75.5,3.8,50,3.8z M71.2,53.3l-30.8,18  c-0.6,0.4-1.3,0.5-1.9,0.5c-0.6,0-1.3-0.1-1.9-0.5c-1.2-0.6-1.9-1.9-1.9-3.3V32c0-1.4,0.8-2.7,1.9-3.3c1.2-0.6,2.7-0.6,3.8,0  l30.8,18c1.2,0.6,1.9,1.9,1.9,3.3S72.3,52.7,71.2,53.3z"></path>
                    </svg>        <span class="tracking-wide font-semibold text-lg mr-2">ASSISTIR</span>
                </a>
            </div>


            <div class="cta my-16 md:my-0">
                <h3 class="text-2xl text-gray-700 font-semibold">
                    Junta-te a nós no Discord!
                </h3>

                <p class="text-lg text-gray-700 mt-6 flex-1">
                    Convidamos-te a entrar  no nosso canal no Discord, partilhares as tuas experiências, a expores as tuas dúvidas e desafiamos-te a criar amizades na melhor comunidade portuguesa de Laravel!
                </p>

                <a href="https://discord.gg/px7DFDb" target="_blank" class="btn bg-blue-500 text-white mx-auto hover:bg-blue-700">
                    <svg viewBox="0 0 245 240" class="fill-current w-8 h-8 mr-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path d="M104.4 103.9c-5.7 0-10.2 5-10.2 11.1s4.6 11.1 10.2 11.1c5.7 0 10.2-5 10.2-11.1.1-6.1-4.5-11.1-10.2-11.1zM140.9 103.9c-5.7 0-10.2 5-10.2 11.1s4.6 11.1 10.2 11.1c5.7 0 10.2-5 10.2-11.1s-4.5-11.1-10.2-11.1z"/><path d="M189.5 20h-134C44.2 20 35 29.2 35 40.6v135.2c0 11.4 9.2 20.6 20.5 20.6h113.4l-5.3-18.5 12.8 11.9 12.1 11.2 21.5 19V40.6c0-11.4-9.2-20.6-20.5-20.6zm-38.6 130.6s-3.6-4.3-6.6-8.1c13.1-3.7 18.1-11.9 18.1-11.9-4.1 2.7-8 4.6-11.5 5.9-5 2.1-9.8 3.5-14.5 4.3-9.6 1.8-18.4 1.3-25.9-.1-5.7-1.1-10.6-2.7-14.7-4.3-2.3-.9-4.8-2-7.3-3.4-.3-.2-.6-.3-.9-.5-.2-.1-.3-.2-.4-.3-1.8-1-2.8-1.7-2.8-1.7s4.8 8 17.5 11.8c-3 3.8-6.7 8.3-6.7 8.3-22.1-.7-30.5-15.2-30.5-15.2 0-32.2 14.4-58.3 14.4-58.3 14.4-10.8 28.1-10.5 28.1-10.5l1 1.2c-18 5.2-26.3 13.1-26.3 13.1s2.2-1.2 5.9-2.9c10.7-4.7 19.2-6 22.7-6.3.6-.1 1.1-.2 1.7-.2 6.1-.8 13-1 20.2-.2 9.5 1.1 19.7 3.9 30.1 9.6 0 0-7.9-7.5-24.9-12.7l1.4-1.6s13.7-.3 28.1 10.5c0 0 14.4 26.1 14.4 58.3 0 0-8.5 14.5-30.6 15.2z"/>
                    </svg>        <span class="tracking-wide font-semibold text-lg mr-2">ADERIR</span>
                </a>
            </div>
        </div>
    </main>

</div>

<script src="/assets/build/js/main.js?id=f8907d6cdc0f277746cd"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-116463385-1"></script>

<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-116463385-1');
</script>
</body>
</html>
