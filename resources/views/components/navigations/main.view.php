<nav id="main-menu">
    <h2 class="sr-only">Menu principal</h2>
    <ul class="flex gap-4">
        <li>
            <a class="underline text-blue-500" href="/jiris">Jiris</a>
        </li>
        <li>
            <a class="underline text-blue-500" href="/contacts">Contacts</a>
        </li>
        <li>
            <a class="underline text-blue-500" href="/projects">Projets</a>
        </li>
        <?php

        use Core\Auth;

        if (Auth::check()):?>
        <li>
            <form action="/logout" method="post">
                <?php
                csrf_token();;
                method('delete');
                component('forms.controls.button-danger' , [
                        'text' => 'Se déconnecter'
                ]);
                ?>
            </form>
        </li>
        <?php else:?>
        <li>
            <a class="underline text-blue-500" href="/login">S'identifier</a>
        </li>
        <li>
            <a class="underline text-blue-500" href="/register">S'enregistrer</a>
        </li>
        <?php endif;?>
    </ul>
</nav>