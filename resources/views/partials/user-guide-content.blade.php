<h1 class="text-5xl font-bold mb-6"> User Guide</h1>

<p class="mb-4">Welcome in the PDF manager app!.</p>
<p>To use the app you must register or log in. This app provides various PDF management functionalities as well as administration of user account and extra features for Admin.</p>

<h2 class="text-xl font-semibold mt-6 mb-2"> Frontend Features</h2>
<ul class="list-disc list-inside mb-4">
    <li class="font-semibold">Registration and login: </li>
    <li>Registration for new users, login for registered ones</li>
    <li>2 roles - Admin and User</li>
    <li>Password change or generating a new password</li>
    <li class="font-semibold">Login history:</li>
    <li>View login history (used functionalities, place, time) for Admin</li>
    <li>Export login history to CSV</li>
    <li>Delete login history</li>
</ul>

<h2 class="text-xl font-semibold mt-6 mb-2"> API Endpoints</h2>

<table class="w-full text-sm border border-gray-300 mb-6">
    <thead class="bg-gray-100 text-left">
    <tr>
        <th class="border-b px-4 py-2">Method</th>
        <th class="border-b px-4 py-2">Endpoint</th>
        <th class="border-b px-4 py-2">Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="border-b px-4 py-2">GET</td>
        <td class="border-b px-4 py-2">/dashboard</td>
        <td class="border-b px-4 py-2">Display user dashboard (auth only)</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">PUT</td>
        <td class="border-b px-4 py-2">/update-password</td>
        <td class="border-b px-4 py-2">Update password manually via form</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">GET</td>
        <td class="border-b px-4 py-2">/reset-password/{token}</td>
        <td class="border-b px-4 py-2">Display reset password form from email</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">GET</td>
        <td class="border-b px-4 py-2">/change-password</td>
        <td class="border-b px-4 py-2">Display change password form</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">POST</td>
        <td class="border-b px-4 py-2">/profile/update-password</td>
        <td class="border-b px-4 py-2">Update password via profile</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">GET</td>
        <td class="border-b px-4 py-2">/profile/edit</td>
        <td class="border-b px-4 py-2">Show edit profile form</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">PATCH</td>
        <td class="border-b px-4 py-2">/profile</td>
        <td class="border-b px-4 py-2">Update user profile</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">DELETE</td>
        <td class="border-b px-4 py-2">/profile</td>
        <td class="border-b px-4 py-2">Delete user account</td>
    </tr>

    <tr class="bg-gray-50">
        <td colspan="3" class="px-4 py-2 font-semibold">Login History (Admin Only)</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">GET</td>
        <td class="border-b px-4 py-2">/login-history</td>
        <td class="border-b px-4 py-2">View login history</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">DELETE</td>
        <td class="border-b px-4 py-2">/login-history</td>
        <td class="border-b px-4 py-2">Delete all login records</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">GET</td>
        <td class="border-b px-4 py-2">/login-history/export</td>
        <td class="border-b px-4 py-2">Export login history to CSV</td>
    </tr>

    <tr class="bg-gray-50">
        <td colspan="3" class="px-4 py-2 font-semibold">User Guide</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">GET</td>
        <td class="border-b px-4 py-2">/user-guide</td>
        <td class="border-b px-4 py-2">View user guide in browser</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">GET</td>
        <td class="border-b px-4 py-2">/user-guide/pdf</td>
        <td class="border-b px-4 py-2">Download user guide as PDF</td>
    </tr>

    <tr class="bg-gray-50">
        <td colspan="3" class="px-4 py-2 font-semibold">Public Pages</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">GET</td>
        <td class="border-b px-4 py-2">/</td>
        <td class="border-b px-4 py-2">Welcome / landing page</td>
    </tr>
    <tr>
        <td class="border-b px-4 py-2">GET</td>
        <td class="border-b px-4 py-2">/main</td>
        <td class="border-b px-4 py-2">Main custom page</td>
    </tr>
    </tbody>
</table>

