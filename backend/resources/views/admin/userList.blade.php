<x-app-layout>
    @section('title', 'アカウント一覧')
    <x-slot name="header">
        {{ __('アカウント一覧') }}
    </x-slot>

    <div class="py-24 -mt-20 sm:flex justify-center md:py-32 lg:py-40 xl:-mt-24">
        <div class="flex justify-center md:-mt-6">
            <form method="post" action="/admin/userList/search" class="form-inline m-5">
                @csrf
                <input type="text" name="search" value="{{$keyword}}" placeholder="アカウントを検索" class="bg-gray-100 hover:bg-white hover:border-gray-300 focus:outline-none focus:bg-white focus:shadow-outline focus:border-gray-300">
                <button class="font-semibold bg-blue-600 text-white hover:opacity-75 py-2 px-4 rounded">
                    検索
                </button>
            </form>
        </div>
    </div>

    @if (isset($err))
    <div class="flex justify-center mb-12 lg:-mt-10">
        <p>{{$err}}</p>
    </div>
    @endif

    @if (isset($users) && !isset($err))
    <div class="max-h-screen flex items-center px-4 -mt-24 md:-mt-24 lg:-mt-32 xl:-mt-32">
        <div class='overflow-x-auto w-full'>
            @if (isset($count) && $count === 0 && !isset($err) && isset($keyword))
            <div class="flex justify-center my-12">
                <p class="-mt-12">該当アカウントがありません。</p>
            </div>
            @endif
            <table class='mx-auto max-w-4xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
                <thead class="bg-gray-600">
                    <tr>
                        <th class="font-semibold text-lg text-white px-6 py-4 text-center">
                            ID
                        </th>
                        <th class="font-semibold text-lg text-white px-6 py-4 text-center">
                            ユーザー名
                        </th>
                        <th class="font-semibold text-lg text-white px-6 py-4 text-center">
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
                            <a href="/admin/userList/delCheck/{{$user->id}}" class="font-semibold text-lg bg-red-600 text-white py-1 px-4 hover:opacity-75 rounded">削除</a>
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
    @endif

    @if (isset($err) || isset($count) && $count === 0 && !isset($err) && isset($keyword))
    <div class="flex justify-center py-12">
        <a href="/admin/list" class="w-24 py-2 bg-blue-600 text-white font-semibold hover:opacity-75 rounded">
            戻る</a>
    </div>
    @endif
</x-app-layout>
