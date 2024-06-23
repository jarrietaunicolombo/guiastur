
# gestionguiasturisticos

Corresponde al repositorio principal del Sistema de Gestión y Control de Turnos para Guías Turísticos que atienden las recaladas de Buques que arriban al puerto de cartagena.

# Casos de uso

## Gestión de Roles

- Crear Rol (1)

- Consultar Rol

- Editar Rol

- Eliminar Rol

- Listar Rol

## Gestion de Países

- Crear País (2)

- Consultar Pais

- Editar Pais

- Eliminar Pais

- Listar País

- Países de los que proviene un buque

## Gestion de Usuarios

- Crear Usuario (3)

- Habilitar Usuario

- Consultar Usuario

- Editar Usuario

- Listar Usuarios

- Habilitar/Deshabilitar Usuario

- Usuarios por Rol

- Iniciar Sesion (8)

## Gestión de Buque

- Crear Buque (4)

- Consultar Buque

- Editar Buque

- Listar Buques

## Gestión de Recalada

- Crear Recalada (5)

- Consultar Recalada

- Editar Recalada

- Listar Recalada

- Listar recaladas por Buque

- Listar Recaladas por número de turistas

- Listar Recalada por periodo

- Listar Recalada por fecha de arribo

- Listar Recalada por fecha de zarpe

- Listar Recalada en el puerto

- Listar Recalada por país de origen

## Gestión de Atención

- Crear Atención (6)

- Iniciar Atencion

- Cerrar Atención

- Ampliar turnos de Atención

- Cambiar de Supervisor

- Consultar Atención

- Editar Atención

- Listar Atenciones

- Listar Atenciones por Recalada

- Listar Atenciones por buque

- Listar Atenciones por Supervisor

- Listar Atenciones por Turnos

- Listar Atenciones por periodo

- Listar Atenciones abiertas

- Listar Atenciones cerradas

- Listar Atenciones por fecha de registro

## Gestión de Turnos

- Crear Turno (7)

- Consultar el próximo turno

- Usar Turno

- Soltar del Turno

- Regresar del Turno

- Cancelar Turno

- Consultar Turno

- Listar Turnos

- Listar turnos por Atención

- Listar turnos por Guia

- Listar turnos por Recalada

- Listar Turnos por Burque

- Listar Turnos por usar

- Listar Turnos usados

- Listar Turnos liberados

- Listar Turnos sin regreso

- Listar Turnos Cancelados

  
  
  

## FLUJO HABITUAL DE UN GUIA TURISTICO


1.  ### Iniciar Sesión

1.1. Query1: Consultar Usuario

1.2. Validar acceso

1.3. Guardar en Sesion: Resultado de la Query1

1.4. Mostrar: menu

  

2.  ### Ver las Recaladas en puerto

2.1. Validar acceso

2.2. Query2: Obtener Recaladas con fecha de arribo <= a fecha actual y fecha de zarpe >= a la fecha actual

2.3. Guardar en Sesion: Resultado de la Query 2

2.4. Mostrar: la lista [id, Buque, Arribo, Zarpe, Turistas, Pais Origen, número de Atenciones]

3.  ### Ver Buque

3.1. Validar Acceso

3.2. Query 3: Obtener datos del Buque por Id

3.3. Guardar datos del Buque en Sesión

3.4 Mostrar: [Id, Codigo, Nombre, foto]

  

4.  ### Ver Atenciones

4.1. Validar Acceso

4.2. Query 4: Obtener las Atenciones Por Id de Recalada

4.3. Query 5: Obtener Cuantos Turnos disponibles tiene una Atención

4.4. Guardar datos del Buque en Sesion Resultado de Query 4 y Query 5

4.5 Mostrar: [Id, Fecha inicio, Fecha Cierre, Total Turnos, Turnos Disponibles, Observaciones, Nombre del Supervisor, RecaladaId, Buque Id]

  

5.  ### Tomar un Turno para una atención

5.1. Validar acceso

5.2. Command1: Crear Turno (AtencionId, GuiaId)

5.3. Guardar en Sesion: Resultado de Command1

5.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, ]

  

6.  ### Ver Siguiente turno

6.1. Validar acceso

6.2. Query 6: Obtener Turnos con Estado Creado por AtencionId (AtencionId)

6.3. Guardar en Sesion: Resultado de la Query 6

6.4. Mostrar [BuqueId, RecaladaId, AtencionId, TunoNumero, GuiaCC, GuiaNombre]

  

7.  ### Usar Turno

7.1. Validar Acceso

7.2. Query 7: ValidarUsoTurno (TurnoId) : Si/NO {El turno solo puede ser Usado por el Guia propietario o Supervisor}

7.3. Guardar en Sesion: Resultado de Query 7

7.4. Command2: Actualizar Turno (TurnoId, FechaUso, Estado:En Uso )

7.5. Guardar en Sesion: Resultado de Command2

7.6. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]

  

8.  ### Liberar Turno

8.1. Validar acceso

8.2. Query 8: Validar Liberar Turno (TurnoId, UsuarioId): SI/NO {El turno solo puede ser liberado por el Guia propietario o Supervisor}

8.3. Guardar en Sesion: Resultado de Query 8

8.4. Command 3: Actualizar Turno (TurnoId, Salida, Estado:Liberado )

8.5. Guardar en Sesion: Resultado de Command 3

8.6. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]

  

9.  ### Terminar Turno

9.1. Validar acceso

9.2. Query 9: Validar Terminar Turno (TurnoId, UsuarioId,¿): SI/NO {El turno solo puede ser Terminado por el Guia propietario o Supervisor}

9.3. Guardar en Sesion: Resultado de Query 9

9.4. Command4: Actualizar Turno (TurnoId, Salida, Estado:Terminado )

9.5. Guardar en Sesion: Resultado de Command2

9.6. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]

  

10.  ### Cancelar Turno

10.1. Validar acceso

10.2. Query 10: Validar Cancelar Turno (TurnoId,UsuarioId): SI/NO {El turno solo puede ser Cancelado por el Guia propietario o Supervisor}

10.3. Guardar en Sesion: Resultado de Query 10

10.4. Comment5: Actualizar Turno (TurnoId, UsuarioId, Estado:Cancelado, FechaUso:Ahora, FechaSalida:FechaUso, FechaRegreso:FechaUso, Observaciones )

10.5. Guardar en Sesion: Resultado de Command2

10.6. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]