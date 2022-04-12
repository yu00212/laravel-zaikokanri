//画像が選択される度に、この中の処理が走る
$("#img_upload").on("change", function(ev) {
    //コンソールタブで適切に処理が動いているか確認
    console.log("image is changed");

    //このFileReaderが画像を読み込む上で大切
    const reader = new FileReader();
    //--ファイル名を取得
    const fileName = ev.target.files[0].name;

    //--画像が読み込まれた時の動作を記述
    reader.onload = function(ev) {
        $("#img_prv")
            .attr("src", ev.target.result)
            .css("width", "150px")
            .css("height", "150px");
    };
    reader.readAsDataURL(this.files[0]);
});
