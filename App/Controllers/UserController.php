<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Repository\UserRepository;

final class UserController extends Controller
{
    private UserRepository $users;

    public function __construct(
        Request $request,
        UserRepository $users
    ) {
        parent::__construct($request);
        $this->users = $users;
    }

    public function profile(): Response
    {
        // TODO: Récupérer l'ID depuis la SESSION. Pour le moment ID = 1 en dur.
        $userId = 1;
        $user = $this->users->findOneById($userId);

        if (!$user) {
            return Response::redirect('/login');
        }

        return $this->view('user/profile', [
            'title' => 'Mon Profil',
            'user' => $user
        ]);
    }

    public function register(): Response
    {
        return $this->view('auth/register', [
            'title' => 'Inscription'
        ]);
    }

    public function handleRegister(): Response
    {
        $email = trim((string) $this->request->input('email'));
        $pwd = (string) $this->request->input('pwd');
        $lastname = trim((string) $this->request->input('lastname'));
        $firstname = trim((string) $this->request->input('firstname'));
        $isHero = $this->request->input('is_hero'); // TODO: checkbox dans le form

        if (empty($email) || empty($pwd)) {
            return $this->view('auth/register', [
                'error' => 'Email et mot de passe obligatoires',
                'title' => 'Inscription'
            ], 422);
        }

        if ($this->users->findOneByEmail($email)) {
            return $this->view('auth/register', [
                'error' => 'Cet email est déjà utilisé',
                'title' => 'Inscription'
            ], 422);
        }

        $role = $isHero ? ['ROLE_HERO_PENDING'] : ['ROLE_CITIZEN'];

        $data = [
            'email' => $email,
            'pwd' => password_hash($pwd, PASSWORD_DEFAULT),
            'lastname' => $lastname,
            'firstname' => $firstname,
            'gender' => $this->request->input('gender') ?? 'Autre',
            'birthdate' => $this->request->input('birthdate'),
            'role' => json_encode($role),
            'street_number' => null,
            'street' => null,
            'zipcode' => null,
            'city' => null
        ];

        $this->users->create($data);

        return Response::redirect('/login');
    }

    public function login(): Response
    {
        return $this->view('auth/login', [
            'title' => 'Connexion'
        ]);
    }
}