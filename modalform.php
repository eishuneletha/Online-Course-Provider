<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .modal-container {
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        background-color: rgba(0, 0, 0, 0.3);
        opacity: 0;
        pointer-events: none;
    }

    .modal {
        background-color: white;
        padding: 30px 50px;
        width: 600px;
        max-width: 100%;
    }

    .modal-container.show{
        opacity: 1;
        pointer-events: auto;
    }
</style>

<body>
    <script>
        const open = document.getElementById('open');
        const modal_container = document.getElementById('modal_container');
        const close = document.getElementById('close');

        open.addEventListener('click', () => {
            modal_container.classList.add('show');
        });

        close.addEventListener('click', () => {
            modal_container.classList.remove('show');
        });


    </script>


    <button id="open">
        click me
    </button>

    <div class="modal-container" id="modal_container">
        <div class="modal">
            <h1>bruh</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo, nesciunt? Nesciunt, vero enim officiis perspiciatis ipsam harum eos fugit temporibus quidem modi alias quasi praesentium aliquam voluptatem assumenda iste id.</p>
            <button id="close">Close me</button>
        </div>

    </div>


</body>

</html>