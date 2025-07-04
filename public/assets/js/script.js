const inputCidade = document.querySelector('input[name="cidade"]');
const sugestoesBox = document.createElement('div');
sugestoesBox.classList.add('autocomplete-sugestoes');
sugestoesBox.style.display = 'none';
inputCidade.parentNode.appendChild(sugestoesBox);

const inputLocationQuery = document.createElement('input');
inputLocationQuery.type = 'hidden';
inputLocationQuery.name = 'location_query';
inputCidade.parentNode.appendChild(inputLocationQuery);

let sugestoes = [];


document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const initialLocationQuery = urlParams.get('location_query');
    if (initialLocationQuery) {
        inputLocationQuery.value = initialLocationQuery;
    }
});


inputCidade.addEventListener('input', function () {
    const valorDigitado = this.value.trim();


    inputLocationQuery.value = valorDigitado;

    if (valorDigitado.length < 2) {
        sugestoesBox.innerHTML = '';
        sugestoesBox.style.display = 'none';
        return;
    }

    fetch(`autocomplete.php?q=${encodeURIComponent(valorDigitado)}`)
        .then(res => {
            if (!res.ok) {
                console.error('Erro ao buscar sugestões:', res.statusText);
                sugestoesBox.innerHTML = `<div class="item-sugestao no-results">Erro ao buscar sugestões.</div>`;
                sugestoesBox.style.display = 'block';
                return Promise.reject('Erro de rede ou API');
            }
            return res.json();
        })
        .then(dados => {
            sugestoesBox.innerHTML = '';
            sugestoes = dados;

            if (dados.length === 0) {
                sugestoesBox.innerHTML = `<div class="item-sugestao no-results">Nenhuma cidade encontrada.</div>`;
                sugestoesBox.style.display = 'block';
                return;
            }

            dados.forEach(item => {
                const div = document.createElement('div');
                div.classList.add('item-sugestao');

                const stringParaBusca = `${item.name}, ${item.region}, ${item.country}`;

                div.textContent = stringParaBusca;
                div.dataset.locationQueryValue = stringParaBusca;

                div.addEventListener('click', () => {
                    inputCidade.value = stringParaBusca;
                    inputLocationQuery.value = div.dataset.locationQueryValue;

                    sugestoesBox.innerHTML = '';
                    sugestoesBox.style.display = 'none';

                    inputCidade.form.submit();
                });

                sugestoesBox.appendChild(div);
            });

            sugestoesBox.style.display = 'block';
        })
        .catch(error => {
            console.error('Erro no processamento da busca de sugestões:', error);
            sugestoesBox.style.display = 'none';
        });
});

document.addEventListener('click', (e) => {
    if (!sugestoesBox.contains(e.target) && e.target !== inputCidade) {
        sugestoesBox.innerHTML = '';
        sugestoesBox.style.display = 'none';
    }
});

inputCidade.form.addEventListener('submit', function (event) {

});