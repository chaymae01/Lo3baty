<h1>Bonjour {{ $client->nom ?? '' }} {{ $client->prenom ?? '' }},</h1>

<p>Merci d'avoir utilisé notre service de location de jouets <strong>Lo3baty</strong> !</p>

<p>Nous vous confirmons que votre réservation <strong>#{{ $reservation->id }}</strong> est <span style="color: green; font-weight: bold;">terminée avec succès</span>.</p>

<hr>

<h2>Détails de votre réservation</h2>

<ul>
    <li><strong>Jouet réservé :</strong> {{ $objet->nom ?? 'un jouet' }}</li>
    <li><strong>Durée :</strong> 
        du {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }} 
        au {{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
    </li>
    @if(isset($annonce->prix_journalier))
    <li><strong>Montant total :</strong> {{ $annonce->prix_journalier * abs(\Carbon\Carbon::parse($reservation->date_debut)->diffInDays(\Carbon\Carbon::parse($reservation->date_fin)) + 1) }} DH</li>
@endif

    @if(isset($objet->categorie))
        <li><strong>Catégorie :</strong> {{ $objet->categorie->nom }}</li>
    @endif
</ul>

<hr>

<h2>Votre avis compte !</h2>

<p>
    Pour nous aider à améliorer nos services, nous vous invitons à évaluer votre expérience de location.
    Cela ne prend que quelques secondes !
</p>

<p>
<a href="http://127.0.0.1:8000/evaluation_annonce/{{ $reservation->id }}">
    Donnez votre avis
</a>

</p>

<hr>

<h2>Et après ?</h2>
<ul>
    <li>Assurez-vous que le jouet est bien retourné dans le même état qu'à la réception.</li>
    <li>Un reçu officiel de location est disponible sur votre compte.</li>
    <li>Besoin d’aide ? Contactez notre équipe ci-dessous.</li>
</ul>

<p>
    📧 <strong>Support :</strong> <a href="mailto:support@lo3baty.com">support@lo3baty.com</a><br>
    📞 <strong>Téléphone :</strong> +212 6 12 34 56 78
</p>

<br>

<p>
    Merci encore pour votre confiance, et à très bientôt sur <strong>Lo3baty</strong> !<br>
    — L'équipe <strong>Lo3baty</strong>
</p>

<p>
    <img src="{{ asset('images/Lo3baty.jpg') }}" alt="Lo3baty Logo" width="150">
</p>
