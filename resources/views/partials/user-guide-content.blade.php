<h1 class="text-5xl font-bold mb-6">{{ __('messages.user_guide') }}</h1>

@if (app()->getLocale() === 'en')
    <p class="mb-4">Welcome in the PDF manager app!</p>
    <p>To use the app you must register or log in. This app provides various PDF management functionalities as well as administration of user account and extra features for Admin.</p>

    <h2 class="text-2xl font-bold mb-4">Frontend functions</h2>
    <ul class="list-disc list-inside mb-4">
        <li class="font-semibold text-xl">Registration and login:
        </li>
        <li> <strong class="text-base">Registration for new users</strong>
            <p class="text-sm text-gray-600 ml-4">To create an account you have to enter your username, email and password</p>
        </li>
        <li> <strong class="text-base">Login for registered users</strong>
            <p class="text-sm text-gray-600 ml-4">To login you have to enter your email and password</p>
        </li>
        <li>2 roles - Admin and User</li>
        <li> <strong class="text-base">Change and renewal of password</strong>
            <p class="text-sm text-gray-600 ml-4">After clicking on the username and entering correct actual password, it can be change to custom or automatically generated strong password</p>
        </li>
        <li class="font-semibold text-xl">Login history:
            <p class="text-sm text-gray-600 ml-4">Functionality available only for admin user</p></li>
        <li> <strong class="text-base">View login history</strong>
            <p class="text-sm text-gray-600 ml-4">See all logins into the app with time, place, country and used functionalities</p>
        </li>
        <li class="text-sm text-gray-600 ml-4">Export login history into CSV</li>
        <li class="text-sm text-gray-600 ml-4">Delete login history</li>
        <li class="font-semibold text-xl">Languages:
        <p class="text-sm text-gray-600 ml-4">Application is available in 2 languages - English and Slovak</p></li>
    </ul>

    <h2 class="text-2xl font-bold mb-4">{{ __('messages.available_functionalities') }}</h2>
    <ul class="list-disc list-inside space-y-4 text-gray-800">
        <li>
            <strong class="text-base">{{ __('messages.remove_pages_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.remove_pages_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.merge_pdfs_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.merge_pdfs_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.pdf_to_jpg_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.pdf_to_jpg_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.jpg_to_pdf_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.jpg_to_pdf_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.rotate_pages_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.rotate_pages_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.split_pdf_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.split_pdf_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.protect_pdf_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.protect_pdf_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.unlock_pdf_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.unlock_pdf_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.resize_pages_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.resize_pages_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.compress_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.compress_desc') }}</p>
        </li>
    </ul><br><br>




@else
    <p class="mb-4">Vitajte v aplikácii PDF manager!</p>
    <p>Na používanie aplikácie sa musíte zaregistrovať alebo prihlásiť. Aplikácia ponúka rôzne funkcie pre prácu s PDF súbormi ako aj správu používateľského účtu a dodatočné funkcie pre administrátorov.</p>

    <h2 class="text-2xl font-bold mb-4">Funkcie frontendu</h2>
    <ul class="list-disc list-inside mb-4">
        <li class="font-semibold text-xl">Registrácia a prihlásenie:
        </li>
        <li> <strong class="text-base">Registrácia nových používateľov</strong>
        <p class="text-sm text-gray-600 ml-4">Na vytvorie konta stačí zadať používateľské meno, email a heslo</p>
        </li>
        <li> <strong class="text-base">Prihlásenie pre zaregistrovaných používateľov</strong>
        <p class="text-sm text-gray-600 ml-4">Na prihlásenie stačí zadať email a nastavené heslo</p>
        </li>
        <li>2 roly - Admin a Používateľ</li>
        <li> <strong class="text-base">Zmena hesla alebo jeho obnovenie</strong>
        <p class="text-sm text-gray-600 ml-4">Po kliknutí na meno používateľa sa dá po zadaní aktuálneho hesla zmeniť - na vlastné alebo vygenerované silné heslo</p>
        </li>
        <li class="font-semibold text-xl">História prihlásení:
        <p class="text-sm text-gray-600 ml-4">Funkcionalita dostupná iba pre používateľa s oprávnením admina</p></li>
        <li> <strong class="text-base">Zobrazenie histórie prihlásení</strong>
        <p class="text-sm text-gray-600 ml-4">Všetky prihlásenia do aplikácie s časom, miestom a použitými funkcionalitami</p>
        </li>
        <li class="text-sm text-gray-600 ml-4">Export histórie do CSV</li>
        <li class="text-sm text-gray-600 ml-4">Vymazanie histórie</li>
        <li class="font-semibold text-xl">Jazyk:
            <p class="text-sm text-gray-600 ml-4">Aplikácia je dostupná v 2 jazykoch - angličtine a slovenčine</p></li>
    </ul>

    <h2 class="text-2xl font-bold mb-4">{{ __('messages.available_functionalities') }}</h2>
    <ul class="list-disc list-inside space-y-4 text-gray-800">
        <li>
            <strong class="text-base">{{ __('messages.remove_pages_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.remove_pages_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.merge_pdfs_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.merge_pdfs_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.pdf_to_jpg_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.pdf_to_jpg_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.jpg_to_pdf_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.jpg_to_pdf_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.rotate_pages_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.rotate_pages_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.split_pdf_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.split_pdf_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.protect_pdf_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.protect_pdf_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.unlock_pdf_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.unlock_pdf_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.resize_pages_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.resize_pages_desc') }}</p>
        </li>
        <li>
            <strong class="text-base">{{ __('messages.compress_title') }}</strong>
            <p class="text-sm text-gray-600 ml-4">{{ __('messages.compress_desc') }}</p>
        </li>
    </ul><br><br>

@endif
