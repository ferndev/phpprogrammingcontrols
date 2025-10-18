// React binder for HtmlTabs in 'react' framework mode
// It reads active/hidden classes from the UL's data attributes and manages state.

(function(){
  const rootEl = document.getElementById('react-tabs-root');
  if(!rootEl) return;

  function bindTabs(ul){
    const activeClasses = (ul.getAttribute('data-active-classes')||'').split(' ').filter(Boolean);
    const hiddenClass = (ul.getAttribute('data-hidden-class')||'hidden');
    const links = Array.prototype.slice.call(ul.querySelectorAll('a'));
    function getTarget(el){
      const href = el.getAttribute('href');
      if(href && href.indexOf('#') === 0) return href.substring(1);
      return el.getAttribute('data-target') || el.getAttribute('aria-controls');
    }
    const paneIds = links.map(getTarget).filter(Boolean);
    const panes = paneIds.map(id => document.getElementById(id)).filter(Boolean);

    function setActiveId(id){
      panes.forEach(p => {
        if(!p) return;
        if(p.id === id){ p.classList.remove(hiddenClass); } else { p.classList.add(hiddenClass); }
      });
      links.forEach(a => {
        activeClasses.forEach(cls => a.classList.remove(cls));
        if(getTarget(a) === id){ activeClasses.forEach(cls => a.classList.add(cls)); }
      });
    }

    // Initial selection: whichever link has an active class, else first
    let initial = null;
    links.some(a => { if(activeClasses.length && activeClasses.every(cls => a.classList.contains(cls))){ initial = a; return true; } return false; });
    if(!initial) initial = links[0] || null;
    if(initial) setActiveId(getTarget(initial));

    links.forEach(a => a.addEventListener('click', e => { e.preventDefault(); setActiveId(getTarget(a)); }));
  }

  // Bind all HtmlTabs with data-active-classes (react mode)
  document.querySelectorAll('ul[role="tablist"][data-active-classes]').forEach(bindTabs);
})();
