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
  if(confirm('Confirmar exclusão?')) window.location = el.href;
});
