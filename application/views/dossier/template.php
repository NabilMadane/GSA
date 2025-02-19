<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dossier Listing</title>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        caption {
            caption-side: top;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Table header */
        thead {
            background-color: #383f8d;
            color: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Table body */
        td {
            font-size: 14px;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }

        /* Total row styling */
        .total-row td {
            font-weight: bold;
            background-color: #e2e2e2;
        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th, td {
                text-align: right;
                padding: 10px;
            }
            th::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
                color: #333;
            }
        }
    </style>
</head>
<body>

<table>
    <caption></caption>
    <thead>
    <tr>
        <th>Noms et Prénom</th>
        <th>Âge</th>
        <th>Analyses</th>
        <th>Prix</th>
        <th>Numéro Téléphone</th>
        <th>Observation</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($dossiers)): ?>
        <?php $totalPrice = 0; ?>
        <?php foreach ($dossiers as $dossier): ?>
            <tr>
                <td><?= htmlspecialchars($dossier->full_name); ?></td>
                <td><?= htmlspecialchars($dossier->age); ?></td>
                <td><?= htmlspecialchars($dossier->analyses_names); ?></td>
                <td style="white-space: nowrap;"><?= htmlspecialchars($dossier->price); ?> DH</td>
                <td><?= htmlspecialchars($dossier->phone); ?></td>
                <td><?= htmlspecialchars($dossier->description); ?></td>
            </tr>
            <?php $totalPrice += $dossier->price; ?>
        <?php endforeach; ?>
        <!-- Total Price Row -->
        <tr class="total-row">
            <td colspan="3" style="text-align: right;">Total:</td>
            <td style="white-space: nowrap;"><?= htmlspecialchars($totalPrice); ?> DH</td>
            <td colspan="2"></td>
        </tr>
    <?php else: ?>
        <tr>
            <td colspan="6" style="text-align: center;">Aucune donnée disponible</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>
