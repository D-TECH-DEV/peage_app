<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de Péage - #TX{{ str_pad($paiement->id, 3, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 20px; }
        .receipt-box { max-width: 300px; margin: 0 auto; border: 1px dashed #ccc; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; color: #1D9E75; }
        .header p { margin: 5px 0 0; font-size: 12px; color: #777; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px; }
        .info-row .label { font-weight: bold; color: #555; }
        .divider { border-bottom: 1px dashed #ccc; margin: 15px 0; }
        .total-row { display: flex; justify-content: space-between; font-size: 16px; font-weight: bold; margin-top: 10px; }
        .footer { text-align: center; margin-top: 20px; font-size: 11px; color: #888; }
        /* Fallback for table-based layout if flexbox is not fully supported by dompdf */
        table { width: 100%; font-size: 13px; margin-bottom: 5px; }
        td.label { font-weight: bold; color: #555; width: 40%; }
        td.value { text-align: right; }
    </style>
</head>
<body>

<div class="receipt-box">
    <div class="header">
        <h1>PÉAGE PRO</h1>
        <p>Reçu de passage officiel</p>
    </div>

    <table>
        <tr>
            <td class="label">Date / Heure :</td>
            <td class="value">{{ \Carbon\Carbon::parse($paiement->date_paiement ?? $paiement->created_at)->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="label">N° de Ticket :</td>
            <td class="value">#TX{{ str_pad($paiement->id, 3, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td class="label">Guichet :</td>
            <td class="value">{{ $paiement->guichet->code ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Agent :</td>
            <td class="value">{{ $paiement->user->nom ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td class="label">Catégorie :</td>
            <td class="value">{{ $paiement->categorieVehicule->libelle ?? 'N/A' }}</td>
        </tr>
        @if($paiement->immatriculation)
        <tr>
            <td class="label">Immatricule. :</td>
            <td class="value">{{ $paiement->immatriculation }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Paiement par :</td>
            <td class="value">{{ $paiement->typePaiement->libelle ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td style="font-size: 16px; font-weight: bold;">TOTAL PAYÉ :</td>
            <td style="font-size: 16px; font-weight: bold; text-align: right;">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
        </tr>
    </table>

    <div class="footer">
        <p>Merci pour votre passage.<br>Bonne route !</p>
    </div>
</div>

</body>
</html>
