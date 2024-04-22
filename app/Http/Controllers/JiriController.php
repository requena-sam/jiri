<?php

namespace App\Http\Controllers;

use App\Models\Jiri;
use Core\Auth;
use Core\Exceptions\FileNotFoundException;
use Core\Response;
use Core\Validator;
use JetBrains\PhpStorm\NoReturn;

class JiriController
{
    private Jiri $jiri;

    public function __construct()
    {
        try {
            $this->jiri = new Jiri(base_path('.env.local.ini'));
        } catch (FileNotFoundException $exception) {
            die($exception->getMessage());
        }
    }

    public function index(): void
    {
        $search = $_GET['search'] ?? '';
        $upcoming_jiris =
            $this->jiri->upcomingBelongingTo(Auth::id());
        $passed_jiris =
            $this->jiri->passedBelongingTo(Auth::id());
        $jiris = $this->jiri->belongingTo(Auth::id());
        view('jiris.index', compact('upcoming_jiris', 'passed_jiris'));
    }

    public function create(): void
    {
        view('jiris.create');
    }

    #[NoReturn] public function store(): void
    {

        $data = Validator::check([
            'name' => 'required|min:3|max:255',
            'starting_at' => 'required|datetime',
        ]);
        $data['user_id'] = Auth::id();

        if ($this->jiri->create($data)) {
            Response::redirect('/jiris');
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

        $jiri = $this->jiri->findOrFail($id);

        $this->checkOwnerShip($jiri);

        $jiri->contacts = $this->jiri->fetchContacts($jiri->id);

        view('jiris.show', compact('jiri'));
    }

    public function edit(): void
    {
        //Récupérer l'id
        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            Response::abort(Response::BAD_REQUEST);
        }
        $id = $_GET['id'];

        $jiri = $this->jiri->findOrFail($id);

        $this->checkOwnerShip($jiri);

        view('jiris.edit', compact('jiri'));
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
            'starting_at' => $_POST['starting_at'],
        ];

        $this->jiri->update($id, $data);

        Response::redirect('/jiri?id=' . $id);
    }

    public function destroy(): void
    {
        //Récupérer l'id
        if (!isset($_POST['id']) || !ctype_digit($_POST['id'])) {
            Response::abort(Response::BAD_REQUEST);
        }
        $id = $_POST['id'];

        $this->jiri->delete($id);

        Response::redirect('/jiris');
    }

    private function checkOwnerShip(mixed $jiri): void
    {
        if (is_numeric($jiri)) {
            $jiri = $this->jiri->findOrFail($jiri);
        }
        if (Auth::id() !== $jiri->user_id) {
            Response::abort(Response::UNAUTHORIZED);
        }
    }
}