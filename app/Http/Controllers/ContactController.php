<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Core\Auth;
use Core\Exceptions\FileNotFoundException;
use Core\Response;
use Core\Validator;
use JetBrains\PhpStorm\NoReturn;

class ContactController
{
    private Contact $contact;

    public function __construct()
    {
        try {
            $this->contact = new Contact(base_path('.env.local.ini'));
        } catch (FileNotFoundException $exception) {
            die($exception->getMessage());
        }
    }

    public function index(): void
    {
        $search = $_GET['search'] ?? '';
        $contacts =
            $this->contact->belongingTo(Auth::id());
        view('contacts.index', compact('contacts'));
    }

    public function create(): void
    {
        view('contacts.create');
    }

    #[NoReturn] public function store(): void
    {

        $data = Validator::check([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
        ]);
        $data['user_id'] = Auth::id();

        if ($this->contact->create($data)) {
            Response::redirect('/contacts');
        } else {
            Response::abort(Response::SERVER_ERROR);
        }
    }

    public function show(): void
    {
        //Récupérer l'id
        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            Response::abort(Response::BAD_REQUEST);
        }
        $id = $_GET['id'];

        $contact = $this->contact->findOrFail($id);

        $this->checkOwnerShip($contact);

        view('contacts.show', compact('contact'));
    }

    public function edit(): void
    {
        //Récupérer l'id
        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            Response::abort(Response::BAD_REQUEST);
        }
        $id = $_GET['id'];

        $contact = $this->contact->findOrFail($id);

        $this->checkOwnerShip($contact);

        view('contacts.edit', compact('contact'));
    }

    public function update(): void
    {
        //Récupérer l'id
        if (!isset($_POST['id']) || !ctype_digit($_POST['id'])) {
            Response::abort(Response::BAD_REQUEST);
        }
        $id = $_POST['id'];

        $this->checkOwnerShip($id);

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
        ];

        $this->contact->update($id, $data);

        Response::redirect('/contact?id=' . $id);
    }

    public function destroy(): void
    {
        //Récupérer l'id
        if (!isset($_POST['id']) || !ctype_digit($_POST['id'])) {
            Response::abort(Response::BAD_REQUEST);
        }
        $id = $_POST['id'];

        $this->contact->delete($id);

        Response::redirect('/contacts');
    }

    private function checkOwnerShip(mixed $contact): void
    {
        if (is_numeric($contact)) {
            $contact = $this->contact->findOrFail($contact);
        }
        if (Auth::id() !== $contact->user_id) {
            Response::abort(Response::UNAUTHORIZED);
        }
    }
}