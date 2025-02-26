<?php

class Leverancier extends BaseController
{
    private $leverancierModel;

    public function __construct()
    {
        $this->leverancierModel = $this->model('LeverancierModel');
    }

    public function index()
    {
        $data = [
            'title' => 'Overzicht Leveranciers Jamin',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL
        ];

        $result = $this->leverancierModel->getAllLeveranciers();

        if (is_null($result)) {
            // Fout afhandelen
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
            $data['dataRows'] = NULL;

            header('Refresh:3; url=' . URLROOT . '/Homepages/index');
        } else {
            $data['dataRows'] = $result;
        }

        $this->view('leverancier/index', $data);
    }

    public function producten($leverancierId)
    {
        $data = [
            'title' => 'Overzicht Leveranciers Jamin',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL
        ];

        $result = $this->leverancierModel->getAllProductenById($leverancierId);

        if (is_null($result)) {
            // Fout afhandelen
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
            $data['dataRows'] = NULL;

            header('Refresh:3; url=' . URLROOT . '/Homepages/index');
        } else if ($result[0]->AantalAanwezig == 0) {
            $data['message'] = "Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin.";
            $data['dataRows'] = $result;
            header('Refresh:3; url=' . URLROOT . '/Leverancier/index');
        } else {
            $data['dataRows'] = $result;
        }

        $this->view('leverancier/producten', $data, $result);
    }

    public function levering($ProductId)
    {
        $data = [
            'title' => 'Levering product',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL
        ];

        $result = $this->leverancierModel->getAllProductDetailsById($ProductId);

        if (is_null($result)) {
            // Fout afhandelen
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
            $data['dataRows'] = NULL;

            header('Refresh:3; url=' . URLROOT . '/Homepages/index');
        } else {
            $data['dataRows'] = $result;
        }

        $this->view('leverancier/levering', $data);
    }

    public function nieuweLevering()
    {
        $data = [
            'title' => 'Levering product',
            'message' => null,
            'messageColor' => null,
            'messageVisibility' => 'none',
            'Aantal' => NULL,
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verwerk formulierdata
            $productId = $_POST['ProductId'];
            $leverancierId = $_POST['LeverancierId'];
            $aantal = $_POST['Aantal'];
            $datumEerstVolgendeLevering = !empty($_POST['DatumEerstVolgendeLevering']) ? $_POST['DatumEerstVolgendeLevering'] : null;
            
            $data['Aantal'] = $aantal;

            if ($datumEerstVolgendeLevering && strtotime($datumEerstVolgendeLevering) < strtotime(date('Y-m-d'))) {
                $result = $this->leverancierModel->getAllProductDetailsById($productId);
                if (!is_null($result)) {
                    $data['dataRows'] = $result;
                }

                $data['message'] = "De geselecteerde datum mag niet in het verleden liggen.";
                $data['messageColor'] = "danger";
                $data['messageVisibility'] = "flex";

                $this->view('leverancier/levering', $data);
                exit;
            }

            // Voeg nieuwe levering toe
            $result = $this->leverancierModel->nieuweLevering($leverancierId, $productId, $aantal, $datumEerstVolgendeLevering);

            if ($result) {
                $data['message'] = "De nieuwe levering is succesvol toegevoegd.";
                $data['messageColor'] = "success";

                // Redirect terug naar leverancierspagina (of een andere locatie)
                header('Location: ' . URLROOT . '/leverancier/producten/' . $leverancierId);
            } else {
                $data['message'] = "Er is een fout opgetreden bij het toevoegen van de levering.";
                $data['messageColor'] = "danger";
            }

            $data['messageVisibility'] = "flex";
            exit;
        } else {
            // Indien geen POST, stuur de gebruiker terug naar leverancierspagina
            header('Location: ' . URLROOT . '/leverancier/index');
            exit;
        }
    }

    public function edit($page = 1)
    {
        $limit = 4; // Aantal records per pagina
        $offset = ($page - 1) * $limit;

        $data = [
            'title' => 'Overzicht Leveranciers',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL,
            'currentPage' => $page,
            'totalPages' => 1 // Defaultwaarde, deze updaten we later
        ];

        // Haal het totaal aantal records op
        $totalLeveranciers = $this->leverancierModel->getTotalLeveranciers();
        $data['totalPages'] = ceil($totalLeveranciers / $limit);

        $result = $this->leverancierModel->getAllLeveranciers($limit, $offset);

        if (is_null($result)) {
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
        } else {
            $data['dataRows'] = $result;
        }

        $this->view('leverancier/edit', $data);
    }

    public function leverancierDetails($leverancierId) 
    {
        $data = [
            'title' => 'Leverancier Details',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL
        ];

        $result = $this->leverancierModel->getLeverancierById($leverancierId);

        if (is_null($result)) {
            // Fout afhandelen
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
            $data['dataRows'] = NULL;

            header('Refresh:3; url=' . URLROOT . '/Homepages/index');
        } else {
            $data['dataRows'] = $result[0];
        }

        $this->view('leverancier/leverancierDetails', $data);
    }

    public function editLeverancier($leverancierId = null)
    {
        // Standaard data-array
        $data = [
            'title' => 'Wijzig Leveranciergegevens',
            'message' => null,
            'messageColor' => null,
            'messageVisibility' => 'none',
            'dataRows' => null
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Formulierdata verwerken
            $data = array_merge($data, [
                'LeverancierId' => $_POST['LeverancierId'],
                'Naam' => trim($_POST['Naam']),
                'ContactPersoon' => trim($_POST['ContactPersoon']),
                'LeverancierNummer' => trim($_POST['LeverancierNummer']),
                'Mobiel' => trim($_POST['Mobiel']),
                'Straatnaam' => trim($_POST['Straatnaam']),
                'Huisnummer' => trim($_POST['Huisnummer']),
                'Postcode' => trim($_POST['Postcode']),
                'Stad' => trim($_POST['Stad']),
            ]);

            // Probeer update uit te voeren
            if ($data['LeverancierId'] == 5) {
                $data['message'] = "Door een technische storing is het niet mogelijk de wijziging door te voeren. 
                                    Probeer hetop een later moment nog eens";
                $data['messageColor'] = "danger";

                header('Refresh:3; url=' . URLROOT . '/Leverancier/leverancierDetails/' . $data['LeverancierId']);
            } else if ($this->leverancierModel->updateLeverancier($data)) {
                $data['message'] = "De leverancier is succesvol bijgewerkt.";
                $data['messageColor'] = "success";

                header('Refresh:3; url=' . URLROOT . '/Leverancier/leverancierDetails/' . $data['LeverancierId']);
            } else {
                $data['message'] = "Er is een fout opgetreden bij het bijwerken van de leverancier.";
                $data['messageColor'] = "danger";
            }

            $data['messageVisibility'] = "flex";
        } else {
            // Ophalen gegevens voor GET-request
            if ($leverancierId) {
                $result = $this->leverancierModel->getLeverancierById($leverancierId);

                if ($result) {
                    $data['dataRows'] = $result[0];
                } else {
                    $data['message'] = "Er is een fout opgetreden bij het ophalen van de gegevens.";
                    $data['messageColor'] = "danger";
                    $data['messageVisibility'] = "flex";
                }
            } else {
                header('Location: ' . URLROOT . '/leverancier/index');
                exit;
            }
        }

        // Toon de view met de bijgewerkte data
        $this->view('leverancier/editLeverancier', $data);
    }
}