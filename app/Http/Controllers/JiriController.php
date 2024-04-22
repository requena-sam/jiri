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
        $jiris = $this->jiri->belongingTo(Auth::id());
        $sql_upcoming_jiris = <<<SQL
                SELECT * FROM jiris 
                         WHERE name LIKE :search  
                               AND starting_at > current_timestamp
                SQL;
        $statement_upcoming_jiris =
            $this->jiri->prepare($sql_upcoming_jiris);
        $statement_upcoming_jiris->bindValue(':search', "%{$search}%");
        $statement_upcoming_jiris->execute();
        $upcoming_jiris =
            $statement_upcoming_jiris->fetchAll();

        $sql_passed_jiris = <<<SQL
                SELECT * FROM jiris 
                         WHERE name LIKE :search
                             AND starting_at < current_timestamp
                SQL;
        $statement_passed_jiris =
            $this->jiri->prepare($sql_passed_jiris);
        $statement_passed_jiris->bindValue(':search', "%{$search}%");
        $statement_passed_jiris->execute();
        $passed_jiris =
            $statement_passed_jiris->fetchAll();

        view('jiris.index', compact('upcoming_jiris', 'passed_jiris','jiris'));
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

        view('jiris.edit', compact('jiri'));
    }

    public function update(): void
    {
        //Récupérer l'id
        if (!isset($_POST['id']) || !ctype_digit($_POST['id'])) {
            Response::abort(Response::BAD_REQUEST);
        }
        $id = $_POST['id'];

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
}