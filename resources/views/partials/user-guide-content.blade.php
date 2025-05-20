<h1 class="text-5xl font-bold mb-6">{{ __('User Guide') }}</h1>

@if (app()->getLocale() === 'en')
    <p class="mb-4">Welcome in the PDF manager app!</p>
    <p>To use the app you must register or log in. This app provides various PDF management functionalities as well as administration of user account and extra features for Admin.</p>

    <h2 class="text-xl font-semibold mt-6 mb-2">Frontend Features</h2>
    <ul class="list-disc list-inside mb-4">
        <li class="font-semibold">Registration and login:</li>
        <li>Registration for new users, login for registered ones</li>
        <li>2 roles - Admin and User</li>
        <li>Password change or generating a new password</li>
        <li class="font-semibold">Login history:</li>
        <li>View login history (used functionalities, place, time) for Admin</li>
        <li>Export login history to CSV</li>
        <li>Delete login history</li>
    </ul>

    <h2 class="text-xl font-semibold mt-6 mb-2">API Endpoints</h2>
    {!! view('user-guide-content.en-api')->render() !!}

@else
    <p class="mb-4">Vitajte v aplikácii PDF manager!</p>
    <p>Na používanie aplikácie sa musíte zaregistrovať alebo prihlásiť. Aplikácia ponúka rôzne funkcie pre prácu s PDF ako aj správu používateľského účtu a dodatočné funkcie pre administrátorov.</p>

    <h2 class="text-xl font-semibold mt-6 mb-2">Funkcie frontendu</h2>
    <ul class="list-disc list-inside mb-4">
        <li class="font-semibold">Registrácia a prihlásenie:</li>
        <li>Registrácia nových používateľov, prihlásenie pre existujúcich</li>
        <li>2 roly - Admin a Používateľ</li>
        <li>Zmena hesla alebo jeho obnovenie</li>
        <li class="font-semibold">História prihlásení:</li>
        <li>Zobrazenie histórie prihlásení (funkcie, čas, IP) – len Admin</li>
        <li>Export histórie do CSV</li>
        <li>Vymazanie histórie</li>
    </ul>

    <h2 class="text-xl font-semibold mt-6 mb-2">API Endpointy</h2>
    <table class="w-full text-sm border border-gray-300 mb-6">
        <thead class="bg-gray-100 text-left">
        <tr>
            <th class="border-b px-4 py-2">Metóda</th>
            <th class="border-b px-4 py-2">Endpoint</th>
            <th class="border-b px-4 py-2">Popis</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="border-b px-4 py-2">GET</td>
            <td class="border-b px-4 py-2">/dashboard</td>
            <td class="border-b px-4 py-2">Zobrazí dashboard prihláseného používateľa</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">PUT</td>
            <td class="border-b px-4 py-2">/update-password</td>
            <td class="border-b px-4 py-2">Zmena hesla cez formulár</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">GET</td>
            <td class="border-b px-4 py-2">/reset-password/{token}</td>
            <td class="border-b px-4 py-2">Zobrazenie formulára z e-mailu</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">GET</td>
            <td class="border-b px-4 py-2">/change-password</td>
            <td class="border-b px-4 py-2">Formulár na zmenu hesla</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">POST</td>
            <td class="border-b px-4 py-2">/profile/update-password</td>
            <td class="border-b px-4 py-2">Zmena hesla cez profil</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">GET</td>
            <td class="border-b px-4 py-2">/profile/edit</td>
            <td class="border-b px-4 py-2">Formulár na úpravu profilu</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">PATCH</td>
            <td class="border-b px-4 py-2">/profile</td>
            <td class="border-b px-4 py-2">Uloženie zmien profilu</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">DELETE</td>
            <td class="border-b px-4 py-2">/profile</td>
            <td class="border-b px-4 py-2">Zmazanie účtu</td>
        </tr>
        <tr class="bg-gray-50">
            <td colspan="3" class="px-4 py-2 font-semibold">História prihlásení (len pre admina)</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">GET</td>
            <td class="border-b px-4 py-2">/login-history</td>
            <td class="border-b px-4 py-2">Zobraziť históriu</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">DELETE</td>
            <td class="border-b px-4 py-2">/login-history</td>
            <td class="border-b px-4 py-2">Vymazať celú históriu</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">GET</td>
            <td class="border-b px-4 py-2">/login-history/export</td>
            <td class="border-b px-4 py-2">Export histórie do CSV</td>
        </tr>
        <tr class="bg-gray-50">
            <td colspan="3" class="px-4 py-2 font-semibold">Verejné stránky</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">GET</td>
            <td class="border-b px-4 py-2">/</td>
            <td class="border-b px-4 py-2">Úvodná stránka</td>
        </tr>
        <tr>
            <td class="border-b px-4 py-2">GET</td>
            <td class="border-b px-4 py-2">/main</td>
            <td class="border-b px-4 py-2">Hlavná stránka aplikácie</td>
        </tr>
        </tbody>
    </table>
@endif
