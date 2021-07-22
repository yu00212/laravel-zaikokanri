<x-admin-layout>
@section('title', 'アカウント一覧')
    <x-slot name="header">
        {{ __('アカウント一覧') }}
    </x-slot>

        <div class="py-24 -mt-20 sm:flex justify-center md:py-32 lg:py-40 xl:-mt-24">

            <div class="flex justify-center md:-mt-6">
                <form method="user" action="/admin/userList/search" class="form-inline m-5">
                @csrf
                    <input type="text" name="search" placeholder="アカウントを検索"
                            class="bg-gray-100 hover:bg-white hover:border-gray-300 focus:outline-none focus:bg-white focus:shadow-outline focus:border-gray-300">
                    <button class="font-semibold border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 text-gray-700 hover:opacity-75 py-2 px-4 rounded">
                    検索
                    </button>
                </form>
            </div>
        </div>

    <div class="max-h-screen flex items-center px-4 -mt-24 md:-mt-24 lg:-mt-32 xl:-mt-40">
        <div class='overflow-x-auto w-full'>
            <table class='mx-auto max-w-4xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
                <thead class="border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200">
                    <tr >
                        <th class="font-semibold text-lg px-6 py-4 text-center">
                            ID
                        </th>
                        <th class="font-semibold text-lg px-6 py-4 text-center">
                            ユーザー名
                        </th>
                        <th class="font-semibold text-lg px-6 py-4 text-center">
                            メールアドレス
                        </th>
                        <th class="font-semibold text-lg px-6 py-4">

                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr class="text-center">
                        <td class="text-lg px-6 py-4">
                            <p class="">
                            {{$user->id}}
                            </p>
                        </td>
                        <td>
                            <p class="text-lg px-6 py-4">
                            {{$user->name}}
                            </p>
                        </td>
                        <td>
                            <p class="text-lg px-6 py-4">
                            {{$user->email}}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-center">
                        <a href="/admin/userList/delCheck/{{$user->id}}" class="font-semibold text-lg border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 text-gray-700 py-1 px-4 hover:opacity-75 rounded">削除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="py-10 mx-auto max-w-4xl w-64 rounded-lg md:py-20 lg:py-32 xl:py-12">
        {{ $users->links() }}
    </div>
</x-admin-layout>