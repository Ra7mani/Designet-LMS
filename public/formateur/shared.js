/* DesignLMS Formateur — shared.js */
(function(){
  var path = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-item[href]').forEach(function(el){
    el.classList.toggle('active', el.getAttribute('href') === path);
  });
})();
var _hbg=document.getElementById('hamburger'), _sb=document.getElementById('sidebar');
if(_hbg&&_sb){
  _hbg.addEventListener('click',function(){ _sb.classList.toggle('open'); });
  document.addEventListener('click',function(e){
    if(window.innerWidth<=900&&!_sb.contains(e.target)&&!_hbg.contains(e.target)) _sb.classList.remove('open');
  });
}
var _tt=null;
window.showToast=function(msg,dur){
  dur=dur||2800;
  var t=document.getElementById('_toast'), m=document.getElementById('_toastMsg');
  if(!t||!m) return;
  m.textContent=msg; t.classList.add('show');
  if(_tt) clearTimeout(_tt);
  _tt=setTimeout(function(){ t.classList.remove('show'); },dur);
};

// Search functionality
window.performSearch = function(query) {
  const resultsDiv = document.getElementById('searchResults');
  const searchInput = document.getElementById('searchInput');

  if (!query || query.length < 2) {
    resultsDiv.style.display = 'none';
    return;
  }

  // Fetch search results
  fetch('/formateur/api/search?q=' + encodeURIComponent(query))
    .then(response => response.json())
    .then(data => {
      displaySearchResults(data, resultsDiv);
    })
    .catch(error => {
      console.error('Search error:', error);
      resultsDiv.innerHTML = '<div class="search-result-item">Erreur lors de la recherche</div>';
      resultsDiv.style.display = 'block';
    });
};

function displaySearchResults(data, container) {
  if (!data || (data.students?.length === 0 && data.courses?.length === 0)) {
    container.innerHTML = '<div class="search-result-item">Aucun résultat trouvé</div>';
    container.style.display = 'block';
    return;
  }

  let html = '';

  // Students results
  if (data.students && data.students.length > 0) {
    data.students.forEach(student => {
      const initials = student.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
      html += `
        <div class="search-result-item" onclick="window.location.href='/formateur/etudiants?student=${student.id}'">
          <div class="search-result-avatar">${initials}</div>
          <div class="search-result-info">
            <div class="search-result-name">${student.name}</div>
            <div class="search-result-type">Étudiant</div>
          </div>
        </div>
      `;
    });
  }

  // Courses results
  if (data.courses && data.courses.length > 0) {
    data.courses.forEach(course => {
      html += `
        <div class="search-result-item" onclick="window.location.href='/formateur/mes-cours/${course.id}'">
          <div class="search-result-avatar">📚</div>
          <div class="search-result-info">
            <div class="search-result-name">${course.title}</div>
            <div class="search-result-type">${course.students_count || 0} étudiant(s)</div>
          </div>
        </div>
      `;
    });
  }

  container.innerHTML = html;
  container.style.display = 'block';
}

// Close search results when clicking outside
document.addEventListener('click', function(e) {
  const searchBar = document.getElementById('searchBar');
  const searchResults = document.getElementById('searchResults');
  if (searchBar && searchResults && !searchBar.contains(e.target)) {
    searchResults.style.display = 'none';
  }
});
