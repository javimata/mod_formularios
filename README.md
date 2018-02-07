# Modulo Joomla mod_formularios
## Version 1.0.1
### Author: @Javi_Mata

# Documentacion (ES)
> Los campos y opciones permitidas son:  
> ***NombreCampo|TipoCampo|Valor|Clase CSS|Obligatorio|Placeholder|Mensaje de error***


| Opciones          | Default   | Valores permitidos | Descripción |
| ----------------- |:---------:|:------:|:-----|
| NombreCampo       |           | String | Es el nombre del campo a tomar en JS |
| TipoCampo         |           | *text, email, date, time, textarea, select, estados, component, checkbox, radio, title, hidden, boton* | Se debe seleccionar un solo tipo de campo, más adelante se explican las opciones para cada uno de ellos |
| Valor             |           | String | Agrega un valor predefinido al campo (opcional) |
| Clase CSS         |           | String | Agrega una clase CSS al contenedor del campo |
| Obligatorio       |           | 1,0    | Indica si el campo es obligatorio: 1 = obligatorio, 0 = opcional |
| Placeholder       |           | String | Se aplica como texto indicativo del campo, por ejemplo el nombre del campo puede ser Nombre y el placeholder decir Nombre completo |
| Mensaje de error  |           | String | Agrega la opcion data-error indicando el texto a mostrar en caso de los campos obligatorios que no son llenados |

### Tipos de campos
text  
email  
date  
time  
textarea  
select  
estados  
component  
checkbox  
radio   
title  
hidden  
boton  