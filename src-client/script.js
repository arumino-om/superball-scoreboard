GETSCORE_URL = "http://localhost/get_scores.php"

BASE_HTML = `
<div class="flex flex-row overflow-hidden truncate m-3">
<div class="mr-3 text-xl font-mono">%NUMBER%</div>
<div>
    <p class="text-xl overflow-hidden truncate">%NAME%</p>
    <p class="text-xs text-gray-500">%AFFILICATION%</p>
    <p class="text-xs">%COUNT%個　獲得した！</p>
</div>
</div>`

function update_score() {
    fetch(GETSCORE_URL)
        .then(response => response.json())
        .then(data => {
            delete_all_child("score");
            prev_score = -1;
            prev_rank = -1;
            for (let i = 0; i < data.length; i++) {
                rank = i + 1;
                if (prev_score == data[i].score) {
                    rank = prev_rank;
                }
                let html = build_html(rank, data[i].name, data[i].affilication, data[i].score);
                let elm = document.createElement("div");
                elm.innerHTML = html;
                document.getElementById("score").appendChild(elm);

                prev_score = data[i].score;
                prev_rank = rank;
            }
            // document.getElementById("score").innerHTML = data.score;
        });
}

function delete_all_child(elm_id) {
    let elm = document.getElementById(elm_id);
    while (elm.firstChild) {
        elm.removeChild(elm.firstChild);
    }
}

function build_html(number, name, aff, score) {
    let html = BASE_HTML;
    html = html.replace("%NUMBER%", number);
    html = html.replace("%NAME%", name);
    html = html.replace("%AFFILICATION%", aff);
    html = html.replace("%COUNT%", score);
    return html;
}

window.onload = function () {
    update_score();
    setInterval(update_score, 1000);
}