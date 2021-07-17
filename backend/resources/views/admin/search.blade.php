<x-app-layout>
@section('title', '在庫検索')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫検索結果') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-3 md:py-8 lg:py-10 xl:py-3 xl:mt-8">
        <form method="post" action="/admin/list/search" class="form-inline m-5">
        @csrf
            <input type="text" name="search" value="{{$keyword}}"
                    class="bg-gray-100 hover:bg-white hover:border-gray-300 focus:outline-none focus:bg-white focus:shadow-outline focus:border-gray-300">
            <button class="font-semibold border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 text-gray-700 hover:opacity-75 py-2 px-4 rounded">
            検索
            </button>
        </form>
    </div>

        @if (isset($err))
        <div class="flex justify-center my-12">
            <p>{{$err}}</p>
        </div>
        @endif

        @if ($count === 0 && !isset($err))
            <div class="flex justify-center my-12 md:my-12">
                <p>該当商品がありません。</p>
            </div>
        @elseif ($count > 0)
        <div class="flex justify-center my-3 lg:py-12 xl:py-12 xl:-mt-12">
            <p>{{$count}}件の該当商品がありました。</p>
        </div>

        <div class="max-h-screen flex items-center px-4 md:mt-3 lg:-mt-3 xl:-mt-12">
        <div class='overflow-x-auto w-full'>
            <table class='mx-auto max-w-4xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
                <thead class="border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200">
                    <tr >
                        <th class="font-semibold text-lg px-6 py-4 text-center">
                            在庫名
                        </th>
                        <th class="font-semibold text-lg px-6 py-4 text-center">
                            ユーザーID
                        </th>
                        <th class="font-semibold text-lg px-6 py-4">

                        </th>
                        <th class="font-semibold text-lg px-6 py-4">

                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach ($stocks as $stock)
                    <tr class="text-center">
                        <td class="text-lg px-6 py-4">
                            <p class="">
                            {{$stock->name}}
                            </p>
                        </td>
                        <td>
                            <p class="text-lg px-6 py-4">
                            {{$stock->user_id}}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-center">
                        <a href="/admin/list/show/{{$stock->id}}" class="font-semibold text-lg border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200  text-gray-700 py-1 px-4 hover:opacity-75 rounded">詳細</a>
                        </td>
                        <td class="px-6 py-4 text-center">
                        <a href="/admin/list/delCheck/{{$stock->id}}" class="font-semibold text-lg border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 text-gray-700 py-1 px-4 hover:opacity-75 rounded">削除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="py-10 mx-auto max-w-4xl w-64 rounded-lg md:py-20 lg:py-32 xl:py-12">
            {{ $stocks->links() }}
        </div>
        @endif

    <div class="flex justify-center py-12">
        <a href="/admin/list"
            class="py-2 px-4 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded md:w-32">一覧に戻る</a>
    </div>



</x-app-layout>