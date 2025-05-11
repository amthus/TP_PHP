<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mémoire Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    /* Général */
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #2c2f36; /* Fond sombre */
        color: #e1e1e1; /* Texte clair pour contraster */
        margin: 0;
        padding: 0;
    }

    /* Boutons */
    .btn {
        display: inline-block;
        padding: 12px 24px;
        margin: 10px;
        text-decoration: none;
        color: white;
        background-color: #007BFF; /* Bleu pour les actions principales */
        border-radius: 8px;
        font-weight: 600;
        text-align: center;
        transition: background 0.3s ease, transform 0.2s ease;
        border: 1px solid transparent;
    }

    .btn:hover {
        background-color: #0056b3; /* Bleu plus foncé au survol */
        transform: translateY(-2px); /* Effet de survol subtil */
    }

    .admin-btn {
        background-color: #343a40; /* Fond plus sombre pour les administrateurs */
    }

    .admin-btn:hover {
        background-color: #1d2124; /* Bleu foncé pour le survol */
    }

    /* Tableaux */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        padding: 14px;
        border: 1px solid #444;
        text-align: left;
    }

    table th {
        background-color: #444; /* Couleur sombre pour les entêtes */
        color: #e1e1e1;
        font-weight: 700;
    }

    table tr:nth-child(even) {
        background-color: #3c4046; /* Alternance de lignes sombres pour la lisibilité */
    }

    table tr:hover {
        background-color: #555; /* Survol des lignes */
    }

    table td {
        background-color: #2c2f36;
    }

    /* Conteneur principal */
    .container {
        padding: 30px;
        max-width: 1100px;
        margin: 0 auto;
        background-color: #383c44; /* Fond légèrement plus clair que celui de la page */
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Formulaires et inputs */
    .form-input {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border-radius: 6px;
        border: 1px solid #555;
        background-color: #444;
        color: #fff;
    }

    .form-input:focus {
        border-color: #007BFF;
        outline: none;
        background-color: #555;
    }

    /* Titre et autres textes */
    h2, h3 {
        color: #e1e1e1;
        font-weight: 700;
    }

    h3 {
        margin-top: 30px;
    }

    /* Liens */
    a {
        color: #007BFF; /* Couleur normale du lien */
        text-decoration: none; /* Supprime le soulignement des liens */
        border-bottom: 2px solid transparent; /* Évite que la bordure apparaisse */
    }

    a:hover {
        color:rgb(83, 219, 56); /* Couleur du lien au survol */
        text-decoration: none; /* Toujours pas de soulignement */
        border-bottom: 2px solid transparent; /* Garde la bordure invisible au survol */
    }


</style>

</head>
<body>
