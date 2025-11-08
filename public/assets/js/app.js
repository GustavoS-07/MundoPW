function validateCountryForm(form){
  const nome = form.nome.value.trim();
  const continente = form.continente.value.trim();
  if(!nome || !continente){ alert('Nome e continente são obrigatórios'); return false; }
  return true;
}
function validateCityForm(form){
  const nome = form.nome.value.trim();
  if(!nome){ alert('Nome da cidade é obrigatório'); return false; }
  return true;
}
document.addEventListener('click', (e)=>{
  const el = e.target.closest('.btn-delete');
  if(!el) return;
  e.preventDefault();
  if(confirm('Confirma exclusão?')) window.location = el.href;
});
document.getElementById('btn-rc')?.addEventListener('click', async ()=>{
  const name = document.getElementById('rc-name').value.trim();
  if(!name) return alert('Digite um nome de país');
  const res = await fetch(`/api/restcountries_proxy.php?name=${encodeURIComponent(name)}`);
  const data = await res.json();
  document.getElementById('rc-result').innerText = JSON.stringify(data, null, 2);
});
