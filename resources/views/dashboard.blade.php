@extends('app')

@section('main')
<h1>Dashboard</h1>
<button id="logoutBtn">Logout</button>

<h2>Adicionar Contato</h2>
<form id="contactForm">
  <input type="text" id="name" placeholder="Nome" required>
  <input type="text" id="cpf" placeholder="CPF" required>
  <input type="text" id="phone" placeholder="Telefone" required>
  <input type="text" id="cep" placeholder="CEP" required>
  <input type="text" id="address" placeholder="Endereço" readonly>
  <button type="submit">Salvar</button>
</form>

<h2>Lista de Contatos</h2>
<ul id="contactsList"></ul>

<h2>Mapa</h2>
@include('components.contact-map')

<script>
  const token = localStorage.getItem('token');
  if (!token) window.location.href = '/login';

  const api = axios.create({
    baseURL: '/api',
    headers: {
      Authorization: `Bearer ${token}`
    }
  });

  document.getElementById('logoutBtn').addEventListener('click', () => {
    api.post('/logout').then(() => {
      localStorage.removeItem('token');
      window.location.href = '/login';
    });
  });

  function loadContacts() {
    api.get('/contacts')
      .then(res => {
        const list = document.getElementById('contactsList');
        list.innerHTML = '';
        res.data.forEach(c => {
          const li = document.createElement('li');
          li.textContent = `${c.name} - ${c.cpf} - ${c.phone} - ${c.address}`;
          list.appendChild(li);
        });
      });
  }
  loadContacts();

  document.getElementById('cep').addEventListener('blur', function() {
    const cep = this.value;
    if (!cep) return;
    api.get(`/cep?cep=${cep}`)
      .then(res => {
        document.getElementById('address').value = `${res.data.logradouro}, ${res.data.bairro}, ${res.data.localidade} - ${res.data.uf}`;
      })
      .catch(() => alert('CEP não encontrado'));
  });

  document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const data = {
      name: document.getElementById('name').value,
      cpf: document.getElementById('cpf').value,
      phone: document.getElementById('phone').value,
      cep: document.getElementById('cep').value,
      address: document.getElementById('address').value
    };
    api.post('/contacts', data).then(() => {
      loadContacts();
      this.reset();
    });
  });
</script>
@endsections