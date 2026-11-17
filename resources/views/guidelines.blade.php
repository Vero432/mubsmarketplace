@extends('layouts.marketplace')

@section('title', 'Community guidelines')

@section('content')

    <div class="bg-white rounded shadow p-6 max-w-3xl">
        <h1 class="text-2xl font-bold mb-4">Community guidelines</h1>

        <h2 class="font-semibold mt-4">What you can post</h2>
        <p>Items and services you own or provide, described honestly, with a fair price and the right category.</p>

        <h2 class="font-semibold mt-4">What you must not post</h2>
        <ul class="list-disc ml-6">
            <li>Illegal, stolen or counterfeit items</li>
            <li>Weapons, drugs or dangerous goods</li>
            <li>Adult, hateful or abusive content</li>
            <li>Misleading descriptions or photos that are not yours</li>
        </ul>

        <h2 class="font-semibold mt-4">Trading safely</h2>
        <ul class="list-disc ml-6">
            <li>Meet in a public place on campus.</li>
            <li>Check the item before you pay.</li>
            <li>Do not send money in advance to someone you have not met.</li>
            <li>Do not share passwords, ID numbers or other sensitive information.</li>
        </ul>

        <h2 class="font-semibold mt-4">About payments</h2>
        <p>This system does not handle payments. Buyers and sellers agree on payment themselves,
           and the system does not guarantee the quality or authenticity of any item.</p>

        <h2 class="font-semibold mt-4">If something goes wrong</h2>
        <p>Use the <strong>Report this listing</strong> button on the listing. An administrator will review it,
           and you can follow its progress under <strong>My reports</strong>.</p>

        <h2 class="font-semibold mt-4">Your information</h2>
        <p>We collect only the details needed to run the marketplace (name, email, registration number
           and phone number). Your phone number and email are not shown on listings or profiles.</p>
    </div>

@endsection