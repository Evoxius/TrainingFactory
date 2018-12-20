const lessen = document.getElementById('lessen');

if (lessen) {
  lessen.addEventListener('click', e => {
    if (e.target.className === 'btn btn-danger delete-les') {
      if (confirm('Are you sure?')) {
        const id = e.target.getAttribute('data-id');

        fetch(`les/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
      }
    }
  });
}