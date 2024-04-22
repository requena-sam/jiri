<form action="/contact"
      method="post"
      class="flex flex-col gap-6">
    <?php
    csrf_token() ?>
    <div class="flex flex-col gap-2">
        <?php
        component('forms.controls.label-and-input', [
            'name' => 'name',
            'label' => 'Nom <small>au moins 3 caractères, au plus 255</small>',
            'type' => 'text',
            'value' => '',
            'placeholder' => 'Jean Valjean'
        ]);
        ?>

    </div>
    <div class="flex flex-col gap-2">
        <?php
        component('forms.controls.label-and-input', [
            'name' => 'email',
            'label' => 'Email <small>adresse valide</small>',
            'type' => 'text',
            'value' => '',
            'placeholder' => 'jeanvaljean@gmail.com'
        ]);
        ?>
    </div>
    <div>
        <?php
        component('forms.controls.button', ['text' => 'Créer ce contact']) ?>
    </div>
    <?php
    $_SESSION['errors'] = [];
    $_SESSION['old'] = [];
    ?>
</form>