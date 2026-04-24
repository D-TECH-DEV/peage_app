<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket - #TX{{ str_pad($paiement->id, 3, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: monospace; font-size: 14px; color: #000; margin: 0; padding: 20px; background: #fff;}
        .receipt-box { max-width: 300px; margin: 0 auto; padding: 10px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px dashed #000; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 12px; }
        .divider { border-bottom: 1px dashed #000; margin: 15px 0; }
        .footer { text-align: center; margin-top: 20px; font-size: 11px; }
        table { width: 100%; font-size: 13px; margin-bottom: 5px; }
        td.label { font-weight: bold; width: 45%; }
        td.value { text-align: right; }
        @media print {
            body { padding: 0; }
            .receipt-box { width: 100%; max-width: 100%; border: none; padding: 0; }
        }
    </style>
</head>
<body onload="window.print(); setTimeout(() => window.close(), 1000);">

<div class="receipt-box">
    <div class="header">
        <h1>PÉAGE PRO</h1>
        <p>Reçu de passage</p>
    </div>

    <table>
        <tr>
            <td class="label">Date:</td>
            <td class="value">{{ \Carbon\Carbon::parse($paiement->date_paiement ?? $paiement->created_at)->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Ticket N°:</td>
            <td class="value">#TX{{ str_pad($paiement->id, 3, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td class="label">Guichet:</td>
            <td class="value">{{ $paiement->guichet->code ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Agent:</td>
            <td class="value">{{ $paiement->user->nom ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td class="label">Catégorie:</td>
            <td class="value">{{ $paiement->categorieVehicule->libelle ?? 'N/A' }}</td>
        </tr>
        @if($paiement->immatriculation)
        <tr>
            <td class="label">Immatricule.:</td>
            <td class="value">{{ $paiement->immatriculation }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Mode paie.:</td>
            <td class="value">{{ $paiement->typePaiement->libelle ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table style="margin-top: 10px;">
        <tr>
            <td style="font-size: 16px; font-weight: bold;">TOTAL:</td>
            <td style="font-size: 16px; font-weight: bold; text-align: right;">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
        </tr>
    </table>

    <div class="footer">
        <p>Merci et bonne route !</p>
    </div>
</div>

</body>
</html>
