<x-app-layout>
@section('title', 'アカウント削除')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('アカウント削除') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-12">
        <p class="py-2 px-4">
        下記のアカウントを削除しますか？</p>
    </div>

    <div class="flex justify-center mt-8">
        <form method="post" action="/admin/userList/delDone/{{$user['id']}}" class="grid grid-cols-1 gap-6">
        @csrf
            <label class="block px-16">
                <span class="text-gray-700">ID</span>
                <input type="number" name="id" value="{{$user['id']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
            </label>

            <label class="block px-16">
                <span class="text-gray-700">ユーザー名</span>
                <input type="text" name="purchase_date" value="{{$user['name']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
            </label>

            <label class="block px-16">
                <span class="text-gray-700">メールアドレス</span>
                <input type="email" name="deadline" value="{{$user['email']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
            </label>

            <div class="flex justify-center mt-12 mb-20">
                <a href="/admin/userList"
                    class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            md:mr-24 xl:mr-32">戻る</a>

                <button class="h-11 w-24 ml-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                                xl:-ml-12">削除</button>
            </div>

            <input type="hidden" name="id" value="{{$user['id']}}">
            <input type="hidden" name="name" value="{{$user['name']}}">
            <input type="hidden" name="email" value="{{$user['email']}}">
        </form>
    </div>
</x-app-layout>

