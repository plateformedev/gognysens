<?php
/**
 * Booking Form Template Part
 * Fallback form when no booking plugin is active
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get passed args
$service = isset($args['service']) ? $args['service'] : '';
$type = isset($args['type']) ? $args['type'] : '';
?>

<div class="cognysens-booking-widget">
    <!-- IA Notice -->
    <div class="ia-notice">
        <strong>Information IA</strong>
        Une intelligence artificielle analysera votre demande pour mieux preparer notre echange.
        <a href="<?php echo esc_url(home_url('/donnees-personnelles-et-ia/')); ?>">En savoir plus</a>
    </div>

    <form class="cognysens-form cognysens-rdv-form" method="post" action="">
        <?php wp_nonce_field('cognysens_rdv', 'rdv_nonce'); ?>

        <!-- Section 1: Coordonnees -->
        <div class="form-section">
            <h3 class="form-section-title">Vos coordonnees</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="rdv-nom">Nom *</label>
                    <input type="text" id="rdv-nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="rdv-prenom">Prenom *</label>
                    <input type="text" id="rdv-prenom" name="prenom" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="rdv-email">Email *</label>
                    <input type="email" id="rdv-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="rdv-telephone">Telephone *</label>
                    <input type="tel" id="rdv-telephone" name="telephone" required>
                </div>
            </div>
        </div>

        <!-- Section 2: Votre bien -->
        <div class="form-section">
            <h3 class="form-section-title">Votre bien</h3>

            <div class="form-group">
                <label for="rdv-type-bien">Type de bien *</label>
                <select id="rdv-type-bien" name="type_bien" required>
                    <option value="">Selectionnez</option>
                    <option value="appartement">Appartement</option>
                    <option value="immeuble">Immeuble entier</option>
                    <option value="maison">Maison ancienne</option>
                    <option value="hotel-particulier">Hotel particulier</option>
                    <option value="batiment-public">Batiment public/Monument</option>
                    <option value="autre">Autre</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="rdv-code-postal">Code postal du bien *</label>
                    <input type="text" id="rdv-code-postal" name="code_postal" required pattern="[0-9]{5}" maxlength="5">
                </div>
                <div class="form-group">
                    <label for="rdv-annee">Annee de construction (approx.)</label>
                    <select id="rdv-annee" name="annee_construction">
                        <option value="">Je ne sais pas</option>
                        <option value="avant-1850">Avant 1850</option>
                        <option value="1850-1900">1850 - 1900</option>
                        <option value="1900-1945">1900 - 1945</option>
                        <option value="1945-1970">1945 - 1970</option>
                        <option value="apres-1970">Apres 1970</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="rdv-qualite">Vous etes *</label>
                <select id="rdv-qualite" name="qualite" required>
                    <option value="">Selectionnez</option>
                    <option value="proprietaire">Proprietaire occupant</option>
                    <option value="bailleur">Proprietaire bailleur</option>
                    <option value="syndic">Syndic de copropriete</option>
                    <option value="conseil-syndical">Conseil syndical</option>
                    <option value="acquereur">Acquereur potentiel</option>
                    <option value="professionnel">Professionnel (architecte, notaire...)</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
        </div>

        <!-- Section 3: Votre besoin -->
        <div class="form-section">
            <h3 class="form-section-title">Votre besoin</h3>

            <div class="form-group">
                <label>Type de prestation souhaitee *</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="rdv-expertise" name="prestation" value="expertise" required <?php echo $service === 'expertise' ? 'checked' : ''; ?>>
                        <label for="rdv-expertise">Expertise technique (diagnostic)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="rdv-amo" name="prestation" value="amo" <?php echo $service === 'amo' ? 'checked' : ''; ?>>
                        <label for="rdv-amo">AMO (accompagnement travaux)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="rdv-dtg" name="prestation" value="dtg" <?php echo $service === 'dtg' ? 'checked' : ''; ?>>
                        <label for="rdv-dtg">DTG (Diagnostic Technique Global)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="rdv-conseil" name="prestation" value="conseil">
                        <label for="rdv-conseil">Simple conseil / orientation</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="rdv-description">Decrivez votre situation *</label>
                <textarea id="rdv-description" name="description" rows="5" required
                    placeholder="Ex: Fissures apparues sur la facade depuis 6 mois, infiltrations au dernier etage..."></textarea>
            </div>

            <div class="form-group">
                <label for="rdv-urgence">Niveau d'urgence</label>
                <select id="rdv-urgence" name="urgence">
                    <option value="normal">Normal (sous 2-3 semaines)</option>
                    <option value="rapide">Rapide (sous 1 semaine)</option>
                    <option value="urgent">Urgent (situation critique)</option>
                </select>
            </div>
        </div>

        <!-- Section 4: Creneau -->
        <div class="form-section">
            <h3 class="form-section-title">Creneau souhaite</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="rdv-date">Date preferee</label>
                    <input type="date" id="rdv-date" name="date_preferee" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                </div>
                <div class="form-group">
                    <label for="rdv-creneau">Creneau prefere</label>
                    <select id="rdv-creneau" name="creneau">
                        <option value="">Peu importe</option>
                        <option value="matin">Matin (9h-12h)</option>
                        <option value="apres-midi">Apres-midi (14h-18h)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- RGPD -->
        <div class="form-group form-group--checkbox">
            <input type="checkbox" id="rdv-rgpd" name="rgpd" required>
            <label for="rdv-rgpd">
                J'accepte que mes donnees soient traitees conformement a la
                <a href="<?php echo esc_url(home_url('/politique-de-confidentialite/')); ?>" target="_blank">politique de confidentialite</a>
                et analysees par une intelligence artificielle pour preparer notre echange. *
            </label>
        </div>

        <button type="submit" class="btn btn-primary btn-lg">
            Demander un rendez-vous
        </button>
    </form>
</div>
