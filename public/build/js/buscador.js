function iniciarApp(){buscarPorFecha(),alertaEliminar(),cerrarSesion(),cambiarFechaAdmin()}function buscarPorFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const n=e.target.value;window.location="?fecha="+n}))}function alertaEliminar(){document.querySelectorAll(".eliminar-servicios").forEach((function(e){e.addEventListener("click",(function(n){n.preventDefault(),Swal.fire({title:"¿Estas seguro?",text:"Estas a punto de eliminar una cita",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Eliminar"}).then(n=>{n.isConfirmed&&Swal.fire({title:"Eliminada",text:"La cita ha sido eliminada correctamente",icon:"success"}).then(()=>e.submit())})}))}))}function cerrarSesion(){document.querySelector("#cerrar-sesion").addEventListener("click",(function(){Swal.fire({title:"¿Estas seguro?",text:"Estas a punto de cerrar sesion",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Cerrar sesion"}).then(e=>{e.isConfirmed&&Swal.fire({title:"Session cerrada",text:"Se ha cerrado la sesion correctamente",icon:"success"}).then(()=>{window.location.replace("/logout")})})}))}function cambiarFechaAdmin(){const e=document.querySelector("#fecha").value,n=document.querySelector("#contenedorFechaAdmin"),t=new Date(e),o=t.getMonth(),a=t.getDate()+2,c=t.getFullYear(),i=new Date(Date.UTC(c,o,a)).toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),r=document.createElement("H3");r.textContent=i,n.appendChild(r)}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));