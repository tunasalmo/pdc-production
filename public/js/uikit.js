(function(){
  function createBackdrop(){
    const b = document.createElement('div');
    b.className = 'modal-backdrop';
    return b;
  }

  function showModal(modal){
    if(!modal) return;
    // append backdrop
    const backdrop = createBackdrop();
    document.body.appendChild(backdrop);
    modal._backdrop = backdrop;
    modal.style.display = 'flex';
    // small delay for transition if needed
    setTimeout(()=> modal.classList.add('show'), 10);
    document.body.classList.add('modal-open');
  }

  function hideModal(modal){
    if(!modal) return;
    modal.classList.remove('show');
    // remove after transition
    setTimeout(()=>{
      modal.style.display = 'none';
      if(modal._backdrop){ modal._backdrop.remove(); delete modal._backdrop; }
      document.body.classList.remove('modal-open');
    }, 180);
  }

  document.addEventListener('click', function(e){
    const dismiss = e.target.closest('[data-bs-dismiss]');
    if(!dismiss) return;
    const target = dismiss.getAttribute('data-bs-dismiss');
    if(target === 'alert'){
      const alert = dismiss.closest('.alert');
      if(alert){
        alert.classList.remove('show');
        setTimeout(()=> alert.remove(), 120);
      }
    } else if(target === 'modal'){
      const modal = dismiss.closest('.modal');
      if(modal) hideModal(modal);
    }
  });

  // expose small API
  window.uikit = { showModal, hideModal };
})();
