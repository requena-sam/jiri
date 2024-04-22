<form action="/login"
      method="post"
      class="flex flex-col gap-6">
    <?php
    csrf_token() ?>
    <div class="flex flex-col gap-2">
        <?php
        component('forms.controls.label-and-input', [
            'name' => 'email',
            'label' => 'Email <small>doit être valide</small>',
            'type' => 'text',
            'value' => '',
            'placeholder' => 'sam@doe.com'
        ]);
        ?>

    </div>
    <div class="flex flex-col gap-2">
        <?php
        component('forms.controls.label-and-input', [
            'name' => 'password',
            'label' => "Mot de passe <small>au moins un chiffre, au moins 8 caractéres et au moins un caractére parmis +-*/?!_</small>",
            'type' => 'text',
            'value' => '',
            'placeholder' => 'ch4ange_th1s'

        ]);
        ?>
    </div>
    <div>
        <?php
        component('forms.controls.button', ['text' => 'S’identifier']) ?>
    </div>
    <?php
    $_SESSION['errors'] = [];
    $_SESSION['old'] = [];
    ?>
</form>