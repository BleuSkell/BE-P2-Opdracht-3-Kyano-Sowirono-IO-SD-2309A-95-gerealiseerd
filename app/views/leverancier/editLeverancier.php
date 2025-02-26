<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3 text-center" style="display:<?= $data['messageVisibility'] ?? 'none'; ?>">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="alert alert-<?= $data['messageColor'] ?? 'secondary'; ?>" role="alert">
                <?= $data['message'] ?? ''; ?>
            </div>
        </div>
        <div class="col-2"></div>
    </div>

    <div class="row mt-3">
        <div class="col-2"></div>
        <div class="col-8">
            <h2><?= $data['title'] ?? 'Wijzig Leveranciergegevens'; ?></h2>
        </div>
        <div class="col-2"></div>
    </div>

    <div class="row mt-3">
        <div class="col-2"></div>
        <div class="col-8">
            <form action="<?= URLROOT; ?>/leverancier/editLeverancier" method="POST">
                <input type="hidden" name="LeverancierId" value="<?= $data['dataRows']->LeverancierId ?? ''; ?>">

                <div class="container d-flex flex-column border border-3 border-black">
                    <div class="d-flex flex-row justify-content-between">
                        <h5>Naam</h5>
                        <input type="text" name="Naam" id="Naam" value="<?= $data['dataRows']->Naam ?? ''; ?>">
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <h5>ContactPersoon</h5>
                        <input type="text" name="ContactPersoon" id="ContactPersoon" value="<?= $data['dataRows']->ContactPersoon ?? ''; ?>">
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <h5>LeverancierNummer</h5>
                        <input type="text" name="LeverancierNummer" id="LeverancierNummer" value="<?= $data['dataRows']->LeverancierNummer ?? ''; ?>">
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <h5>Mobiel</h5>
                        <input type="text" name="Mobiel" id="Mobiel" value="<?= $data['dataRows']->Mobiel ?? ''; ?>">
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <h5>Straatnaam</h5>
                        <input type="text" name="Straatnaam" id="Straatnaam" value="<?= $data['dataRows']->Straatnaam ?? ''; ?>">
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <h5>Huisnummer</h5>
                        <input type="text" name="Huisnummer" id="Huisnummer" value="<?= $data['dataRows']->Huisnummer ?? ''; ?>">
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <h5>Postcode</h5>
                        <input type="text" name="Postcode" id="Postcode" value="<?= $data['dataRows']->Postcode ?? ''; ?>">
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <h5>Stad</h5>
                        <input type="text" name="Stad" id="Stad" value="<?= $data['dataRows']->Stad ?? ''; ?>">
                    </div>
                </div>

                <div class="d-flex flex-row justify-content-between mt-3">
                    <button type="submit">Sla op</button>

                    <div>
                        <a href="<?= URLROOT; ?>/leverancier/edit"><button type="button">Terug</button></a>
                        <a href="<?= URLROOT; ?>/homepages/index"><button type="button">home</button></a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-2"></div>
    </div>
</div>


<?php require_once APPROOT . '/views/includes/footer.php'; ?>