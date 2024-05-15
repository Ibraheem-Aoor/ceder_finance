<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Btw-aangifte {{ $quarter }}e kwartaal 2024 (ingediend)
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body>
    <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded bg-gray-100 p-8" id="boxes">
        <h1 class="text-xl font-bold mb-4">
            Btw-aangifte {{ $quarter }}e kwartaal 2024 (ingediend)
        </h1>
        <div class="mb-4">
            <p>
                Ceder B.V.
            </p>
            <p>
                Betalingskenmerk: 3865931781401210
            </p>
            <p>
                Ontvangen door Belastingdienst: 08 april 2024 13:31
            </p>
        </div>
        <table class="w-full text-sm">
            <tbody>
                <tr>
                    <td class="font-bold py-2" colspan="4">
                        1 Prestaties binnenland
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        1a Leveringen/diensten belast met hoog tarief (21%)
                    </td>
                    {{-- Total Income Inside NL (21%) --}}
                    <td class="text-right">
                        {{ $total_income_nl_21 }}
                    </td>
                    {{-- Total NL Tax --}}
                    <td class="text-right">
                        {{ $total_tax_nl_21 }}
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        1b Leveringen/diensten belast met laag tarief (9%)
                    </td>
                    <td class="text-right">
                        {{ $total_income_nl_9 }}
                    </td>
                    <td class="text-right">
                        {{ $total_tax_nl_9 }}
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        1c Leveringen/diensten belast met overige tarieven, behalve 0%
                    </td>
                    <td class="text-right">
                        € 0
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        1d Privégebruik
                    </td>
                    <td class="text-right">
                        € 0
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        1e Leveringen/diensten belast met 0% of niet bij u belast (Verlegd binnen NL)
                    </td>
                    <td class="text-right">
                        € 0
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="font-bold py-2" colspan="4">
                        2 Verleggingsregelingen binnenland
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        2a Leveringen/diensten waarbij de omzetbelasting naar u is verlegd
                    </td>
                    <td class="text-right">
                        € 0
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="font-bold py-2" colspan="4">
                        3 Prestaties naar of in het buitenland
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        3a Leveringen naar landen buiten de EU (uitvoer)
                    </td>
                    <td class="text-right">
                        € 0
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        3b Leveringen naar of diensten in landen binnen de EU
                    </td>
                    <td class="text-right">
                        € 0
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        3c Installatie/afstandsverkopen binnen de EU
                    </td>
                    <td class="text-right">
                        € 0
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="font-bold py-2" colspan="4">
                        4 Prestaties vanuit het buitenland aan u verricht
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        4a Leveringen/diensten uit landen buiten de EU
                    </td>
                    <td class="text-right">
                        € 0
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        4b Leveringen/diensten uit landen binnen de EU
                    </td>
                    <td class="text-right">
                        € 0
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="font-bold py-2" colspan="4">
                        5 Voorbelasting en eindtotaal
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        5a Verschuldigde omzetbelasting (rubrieken 1 t/m 4)
                    </td>
                    <td class="text-right">
                    </td>
                    <td class="text-right">
                        {{ $total_income_taxes }}
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        5b Voorbelasting (21% + 9%)
                    </td>
                    <td class="text-right">
                    </td>
                    <td class="text-right">
                        {{ $total_expense_tax }}

                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="py-1">
                        5g Totaal 
                    </td>
                    <td class="text-right">
                    </td>
                    <td class="text-right">
                        {{ $total_taxes }}
                    </td>
                    <td>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="{{ asset('assets/js/jquery.min.js') }} "></script>
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        function closeScript() {
            setTimeout(function() {
                window.open(window.location, '_self').close();
            }, 1000);
        }

        $(window).on('load', function() {
            var element = document.getElementById('boxes');
            var opt = {
                filename: '{{ \Carbon\Carbon::now()->toDateTimeString() }}',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 4,
                    dpi: 72,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A4'
                }
            };
            html2pdf().set(opt).from(element).save().then(closeScript);
        });
    </script>

</body>

</html>
