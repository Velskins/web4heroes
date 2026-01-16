<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Repository\IncidentRepository;
use App\Repository\VillainRepository;

final class IncidentController extends Controller
{
    private IncidentRepository $incidents;
    private VillainRepository $villains;

    public function __construct(
        Request $request,
        IncidentRepository $incidents,
        VillainRepository $villains
    ) {
        parent::__construct($request);
        $this->incidents = $incidents;
        $this->villains = $villains;
    }

    public function index(): Response
    {
        $incidents = $this->incidents->findAll();

        return $this->view('incident/index', [
            'title' => 'Incidents en cours',
            'incidents' => $incidents
        ]);
    }

    public function show(): Response
    {
        $id = (int) $this->request->query('id');

        $incident = $this->incidents->findOneById($id);

        if (!$incident) {
            return new Response('Incident introuvable', 404);
        }

        return $this->view('incident/show', [
            'incident' => $incident
        ]);
    }

    public function create(): Response
    {
        return $this->view('incident/create', [
            'title' => 'Déclarer un incident',
            'villains' => $this->villains->findAll()
        ]);
    }

    public function store(): Response
    {
        $data = [
            'title' => trim((string) $this->request->input('title')),
            'description' => trim((string) $this->request->input('description')),
            'date' => date('Y-m-d H:i:s'), 
            'priority' => 'Basse', 
            'type' => $this->request->input('type'), 
            'status' => "Signalé à l'instant",
            'users_id' => 1, // TODO: ID utilisateur connecté

            'villain_profile_id' => $this->request->input('villain_profile_id') ?: null,

            'address_numero' => (int) $this->request->input('numero'),
            'address_complement' => $this->request->input('complement_numero'),
            'address_street' => trim((string) $this->request->input('street')),
            'address_zipcode' => (int) $this->request->input('zipcode'),
            'address_city' => trim((string) $this->request->input('city')),
        ];

        if (empty($data['title']) || empty($data['address_city'])) {
            return $this->view('incident/create', [
                'error' => 'Le titre et la ville sont obligatoires',
                'villains' => $this->villains->findAll(),
                'data' => $data 
            ], 422);
        }

        $this->incidents->create($data);

        return Response::redirect('/incidents');
    }
}