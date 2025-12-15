function luhnCheck(pan){
  const digits = pan.replace(/\D/g,'');
  if(!digits) return false;
  let sum=0, alt=false;
  for(let i=digits.length-1;i>=0;i--){
    let d=parseInt(digits[i],10);
    if(alt){d*=2; if(d>9) d-=9}
    sum+=d; alt=!alt;
  }
  return sum%10===0;
}

function detectBrand(pan){
  if(!pan) return null;
  if(pan.startsWith('4')) return 'Visa';
  if(/^(51|52|53|54|55)/.test(pan)) return 'MasterCard';
  if(pan.startsWith('34')||pan.startsWith('37')) return 'American Express';
  if(pan.startsWith('6')) return 'Discover';
  return 'Unknown';
}

function maskPan(pan){
  const digits = pan.replace(/\D/g,'');
  if(digits.length<=4) return '*'.repeat(digits.length);
  return '*'.repeat(digits.length-4)+digits.slice(-4);
}

const panInput=document.getElementById('pan');
const panDisplay=document.getElementById('panDisplay');
const brandEl=document.getElementById('brand');
const luhnEl=document.getElementById('luhn');
const binInfoEl=document.getElementById('binInfo');
let isMasked=true;

function updateDisplay(){
  const v=panInput.value.trim();
  panDisplay.textContent = v? (isMasked?maskPan(v):v):'—';
  brandEl.textContent = v?detectBrand(v):'—';
  luhnEl.textContent = v? (luhnCheck(v)?'yes':'no') : '—';
}

panInput.addEventListener('input',()=>{ updateDisplay(); binInfoEl.textContent='—'; });

document.getElementById('maskBtn').addEventListener('click',()=>{ isMasked=!isMasked; updateDisplay(); });

document.getElementById('lookupBinBtn').addEventListener('click', async ()=>{
  const v=panInput.value.replace(/\D/g,'');
  if(v.length<6){ alert('Enter at least 6 digits for BIN lookup'); return }
  const bin=v.slice(0,6);
  try{
    const res=await fetch(`/bin_lookup?bin=${bin}`);
    if(!res.ok){ binInfoEl.textContent='Lookup error'; return }
    const data=await res.json();
    binInfoEl.textContent = JSON.stringify(data,null,2);
  }catch(err){ binInfoEl.textContent='Network error' }
});

updateDisplay();
