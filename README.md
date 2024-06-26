
# gestionguiasturisticos

Corresponde al repositorio principal del Sistema de Gestión y Control de Turnos para Guías Turísticos que atienden las recaladas de Buques que arriban al puerto de cartagena.



## FLUJO HABITUAL DE TRABAJO



1.  ### Iniciar Sesión (Super Admin, Supervisor, Guia)

1.1. Query1: Consultar Usuario

1.2. Validar acceso

1.3. Guardar en Sesion: Resultado de la Query1

1.4. Mostrar: menu

  

2.  ### Ver las Recaladas en puerto  (Super Admin, Supervisor, Guia)

2.1. Validar acceso

2.2. Query2: Obtener Recaladas con fecha de arribo <= a fecha actual y fecha de zarpe >= a la fecha actual

2.3. Guardar en Sesion: Resultado de la Query 2

2.4. Mostrar: la lista [id, Buque, Arribo, Zarpe, Turistas, Pais Origen, número de Atenciones]
 
 

3.  ### Ver Buque  (Super Admin, Supervisor, Guia)

3.1. Validar Acceso

3.2. Query 3: Obtener datos del Buque por Id

3.3. Guardar datos del Buque en Sesión

3.4 Mostrar: [Id, Codigo, Nombre, foto]

  

4.  ### Ver Atenciones  (Super Admin, Supervisor, Guia)

4.1. Validar Acceso

4.2. Query 4: Obtener las Atenciones Por Id de Recalada

4.3. Query 5: Obtener Cuantos Turnos disponibles tiene una Atención

4.4. Guardar datos del Buque en Sesion Resultado de Query 4 y Query 5

4.5 Mostrar: [Id, Fecha inicio, Fecha Cierre, Total Turnos, Turnos Disponibles, Observaciones, Nombre del Supervisor, RecaladaId, Buque Id]

  

5.  ### Tomar un Turno para una atención  (Guia)

5.1. Validar acceso

5.2. Command1: Crear Turno (AtencionId, GuiaId)

5.3. Guardar en Sesion: Resultado de Command1

5.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, ]

  

6.  ### Ver Siguiente turno  (Super Admin, Supervisor, Guia)

6.1. Validar acceso

6.2. Query 6: Obtener Turnos con Estado Creado por AtencionId (AtencionId)

6.3. Guardar en Sesion: Resultado de la Query 6

6.4. Mostrar [BuqueId, RecaladaId, AtencionId, TunoNumero, GuiaCC, GuiaNombre]

  

7.  ### Usar Turno  (Supervisor, Guia)

7.1. Validar Acceso

7.2. Query 7: ValidarUsoTurno (TurnoId, GuiaId) : Si/NO {El turno solo puede ser Usado por el Guia propietario o Supervisor}

7.3. Guardar en Sesion: Resultado de Query 7

7.4. Command 2: Actualizar Turno (TurnoId, FechaUso, Estado:En Uso )

7.5. Guardar en Sesion: Resultado de Command 2

7.6. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]

  

8.  ### Liberar Turno (Supervisor, Guia)

8.1. Validar acceso

8.2. Query 8: Validar Liberar Turno (TurnoId, UsuarioId): SI/NO {El turno solo puede ser liberado por el Guia propietario o Supervisor}

8.3. Guardar en Sesion: Resultado de Query 8

8.4. Command 3: Actualizar Turno (TurnoId, Salida, Estado:Liberado )

8.5. Guardar en Sesion: Resultado de Command 3

8.6. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]

  

9.  ### Terminar Turno (Supervisor, Guia)

9.1. Validar acceso

9.2. Query 9: Validar Terminar Turno (TurnoId, UsuarioId,¿): SI/NO {El turno solo puede ser Terminado por el Guia propietario o Supervisor}

9.3. Guardar en Sesion: Resultado de Query 9

9.4. Command 4: Actualizar Turno (TurnoId, Salida, Estado:Terminado )

9.5. Guardar en Sesion: Resultado de Command 4

9.6. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]

  

10.  ### Cancelar Turno (Supervisor, Guia)

10.1. Validar acceso

10.2. Query 10: Validar Cancelar Turno (TurnoId,UsuarioId): SI/NO {El turno solo puede ser Cancelado por el Guia propietario o Supervisor}

10.3. Guardar en Sesion: Resultado de Query 10

10.4. Comment 5: Actualizar Turno (TurnoId, UsuarioId, Estado:Cancelado, FechaUso:Ahora, FechaSalida:FechaUso, FechaRegreso:FechaUso, Observaciones )

10.5. Guardar en Sesion: Resultado de Command 5

10.6. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]



## FLUJO HABITUAL DE TRABAJO HABITUAL DE ADMINISTRACION


11.  ### Crear Rol (Super Admin)

11.1. Validar acceso

11.1. Command 6: Crear Rol (nombre, descripcion, [Icono], UsuarioId:Usuario Login)

11.3. Guardar en Sesion: Resultado de la Command 6

11.4. Mostrar: [id, nombre, descripcion, icono, fecha Creacion]


12.  ### Editar Rol (Super Admin)

12.1. Validar acceso

12.2. Query 11: Obtener Rol (Rolid)

12.3.  Guardar en Sesion: Resultado Query 11

12.4. Command 7: Actulizar Rol por Id (RolId, [nombre], [descripcion], [Icono])

12.5. Guardar en Sesion: Resultado del Command 7

12.6. Mostrar: [id, nombre, descripcion, icono, fecha Creacion]


13.  ### Listar Roles (Super Admin)

13.1. Validar acceso

13.2. Query 12: Obtener todos los Roles

13.3.  Guardar en Sesion: Resultado Query 12

13.4. Mostrar: [id, nombre, descripcion, icono, fecha Creacion]


14.  ### Crear Pais  (Super Admin, Supervisor)

14.1. Validar acceso

14.1. Command 8: Crear Pais (nombre, [Bandera],  UsuarioId:Usuario Login)

14.3. Guardar en Sesion: Resultado de la Command 8

14.4. Mostrar: [id, nombre, Bandera, fecha Creacion]


15.  ### Editar Pais (Super Admin, Supervisor)

15.1. Validar acceso

15.2. Query 13: Obtener Pais (PaisId)

15.3.  Guardar en Sesion: Resultado Query 12

15.4. Command 9: Actulizar Pais por Id (Pais, [nombre], UsuarioId:Usuario Login)

15.5. Guardar en Sesion: Resultado del Command 9

15.6. Mostrar: [id, nombre, bandera, fecha Creacion]


16.  ### Listar Paises (Super Admin, Supervisor, Guia)

16.1. Validar acceso

16.2. Query 14: Obtener todos los Paises

16.3.  Guardar en Sesion: Resultado Query 13

16.4. Mostrar: [id, nombre, bandera, fecha Creacion]


17.  ### Crear Buque  (Super Admin, Supervisor)

17.1. Validar acceso

17.1. Command 10: Crear Buque (Codigo, Nombre, [Foto], UsuarioId:Usuario Login)

17.3. Guardar en Sesion: Resultado de la Command 10

17.4. Mostrar: [id, codigo, nombre, foto, fecha Creacion]


18.  ### Editar Buque (Super Admin, Supervisor)

18.1. Validar acceso

18.2. Query 15: Obtener Buque (BuqueId)

18.3.  Guardar en Sesion: Resultado Query 15

18.4. Command 11: Actulizar Buque por Id (BuqueId, [Codigo], [Nombre], [Foto], UsuarioId:Usuario Login)

18.5. Guardar en Sesion: Resultado del Command 11

18.6. Mostrar: [id, Codigo, nombre, foto, fecha Creacion]


19.  ### Listar Buques (Super Admin, Supervisor, Guia)

19.1. Validar acceso

19.2. Query 16: Obtener todos los Buques

19.3.  Guardar en Sesion: Resultado Query 16

19.4. Mostrar: [id, Codigo, nombre, foto, fecha Creacion]


19.  ### Crear Reacalada  (Super Admin, Supervisor)

19.1. Validar acceso

19.1. Command 12: Crear Recalada (FechaArribo, FechaZarpe, TotalTuristas, [Observaciones], BuqueId, PaisId, UsuarioId:Usuario Login)

19.3. Guardar en Sesion: Resultado de la Command 12

19.4. Mostrar: (Id, FechaArribo, FechaZarpe, TotalTuristas, [Observaciones], BuqueId, Buque Nombre, Pais Nombre, Fecha Creacion)


20.  ### Editar Recalada (Super Admin, Supervisor)

20.1. Validar acceso

20.2. Query 17: Obtener Recalada (RecaladaID)

20.3.  Guardar en Sesion: Resultado Query 17

20.4. Command 13: Actulizar Recalada por Id (RecaladaId, [FechaArribo], [FechaZarpe], [TotalTuristas], [Observaciones], [PaisId],UsuarioId:Usuario Login)

20.5. Guardar en Sesion: Resultado del Command 13

20.6. Mostrar: (Id, FechaArribo, FechaZarpe, TotalTuristas, [Observaciones], BuqueId, Buque Nombre, Pais Nombre, Fecha Creacion)


21.  ### Listar Recaladas (Super Admin, Supervisor, Guia)

21.1. Validar acceso

21.2. Query 18: Obtener todos las Recaladas(BuqueId)

21.3.  Guardar en Sesion: Resultado Query 18

21.4. Mostrar: (Id, FechaArribo, FechaZarpe, TotalTuristas, [Observaciones], BuqueId, Buque Nombre, Pais Nombre, Fecha Creacion)


22.  ### Crear Atencion  (Super Admin, Supervisor)

22.1. Validar acceso

22.1. Command 14: Crear Atencion (FechaInicio, [FechaCierre], TotalTurnos, [Observaciones], SupervisorId, RecaladaId, UsuarioId:Usuario Login)

22.3. Guardar en Sesion: Resultado de la Command 14

22.4. Mostrar: (Id, FechaInicio, FechaCierre, TotalTurnos, [Observaciones], SupervisorId, SupervisorNombre, BuqueId, BuqueNombre, RecaladaId, Fecha Creacion)


23.  ### Editar Atencion (Super Admin, Supervisor)

23.1. Validar acceso

23.2. Query 19: Obtener Atencion (AtencionId)

23.3.  Guardar en Sesion: Resultado Query 19

23.4. Command 15: Actulizar Atencion por Id (Atencionid, [FechaInicio], [FechaCierre], [TotalTurnos], [Observaciones],UsuarioId:Usuario Login)

23.5. Guardar en Sesion: Resultado del Command 15

23.6. Mostrar: (Id, FechaInicio, FechaCierre, TotalTurnos, [Observaciones], SupervisorId, SupervisorNombre, BuqueId, BuqueNombre, RecaladaId, Fecha Creacion)


24.  ### Listar Atenciones Por Recalada (Super Admin, Supervisor, Guia)

24.1. Validar acceso

24.2. Query 20: Obtener Atenciones por Recalada (RecladaId)

24.3.  Guardar en Sesion: Resultado Query 20

24.4.  Mostrar: (Id, FechaInicio, FechaCierre, TotalTurnos, [Observaciones], SupervisorId, SupervisorNombre, BuqueId, BuqueNombre, RecaladaId, Fecha Creacion)


25.  ### Listar Atenciones Por Buque (Super Admin, Supervisor, Guia)

25.1. Validar acceso

25.2. Query 21: Obtener Atenciones por Buque (BuqueId)

25.3.  Guardar en Sesion: Resultado Query 21

25.4.  Mostrar: (Id, FechaInicio, FechaCierre, TotalTurnos, [Observaciones], SupervisorId, SupervisorNombre, BuqueId, BuqueNombre, RecaladaId, Fecha Creacion)


26.  ### Listar Atenciones Por Supervisor (Super Admin, Supervisor, Guia)

26.1. Validar acceso

26.2. Query 22: Obtener Atenciones por Supervisor (SupervisorId)

26.3.  Guardar en Sesion: Resultado Query 22

26.4.  Mostrar: (Id, FechaInicio, FechaCierre, TotalTurnos, [Observaciones], SupervisorId, SupervisorNombre, BuqueId, BuqueNombre, RecaladaId, Fecha Creacion)


27.  ### Listar Atenciones Por Fecha (Super Admin, Supervisor, Guia)

27.1. Validar acceso

27.2. Query 23: Obtener Atenciones Por Periodo (Fecha1, Fecha2)

27.3.  Guardar en Sesion: Resultado Query 23

27.4.  Mostrar: (Id, FechaInicio, FechaCierre, TotalTurnos, [Observaciones], SupervisorId, SupervisorNombre, BuqueId, BuqueNombre, RecaladaId, Fecha Creacion)


28.  ### Listar Todos los Turnos  (Super Admin, Supervisor, Guia)

28.1. Validar acceso

28.2. Query 24: Obtener todos los Turnos 

28.3.  Guardar en Sesion: Resultado Query 24

28.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]


29.  ### Listar Turnos Por Estado  (Super Admin, Supervisor, Guia)

29.1. Validar acceso

29.2. Query 25: Obtener Turnos Por estado (Estado)

29.3.  Guardar en Sesion: Resultado Query 24

29.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]


30.  ### Listar Turnos Por Fecha de Creacion (Super Admin, Supervisor, Guia)

30.1. Validar acceso

30.2. Query 26: Obtener Turnos Por Periodo de Creacion (Fecha1, Fecha2)

30.3.  Guardar en Sesion: Resultado Query 26

30.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]


31.  ### Listar Turnos Por Fecha de Uso (Super Admin, Supervisor, Guia)

31.1. Validar acceso

31.2. Query 27: Obtener Turnos por Fecha de Uso  (Fecha1, Fecha2)

31.3.  Guardar en Sesion: Resultado Query 27

31.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]


32.  ### Listar Turnos Por Fecha de Liberacion (Super Admin, Supervisor, Guia)

32.1. Validar acceso

32.2. Query 28: Obtener Turnos por Fecha de Liberacion  (Fecha1, Fecha2)

32.3.  Guardar en Sesion: Resultado Query 28

32.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]


33.  ### Listar Turnos Por Fecha de Terminacion (Super Admin, Supervisor, Guia)

33.1. Validar acceso

33.2. Query 29: Obtener Turnos por Fecha de Terminacion  (Fecha1, Fecha2)

33.3.  Guardar en Sesion: Resultado Query 29

33.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]


34.  ### Listar Turnos Por Guia (Super Admin, Supervisor, Guia)

34.1. Validar acceso

34.2. Query 30: Obtener Turnos por Guia (GuiaId)

34.3.  Guardar en Sesion: Resultado Query 30

34.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]


35.  ### Listar Turnos Por Atencion (Super Admin, Supervisor, Guia)

35.1. Validar acceso

35.2. Query 31: Obtener Turnos por Atencion (AtencionId)

35.3.  Guardar en Sesion: Resultado Query 31

35.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]


36.  ### Listar Turnos Por Recalada (Super Admin, Supervisor, Guia)

36.1. Validar acceso

36.2. Query 32: Obtener Turnos por Recalada (RecaladaId)

36.3.  Guardar en Sesion: Resultado Query 32

36.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]


37.  ### Listar Turnos Por Buque (Super Admin, Supervisor, Guia)

37.1. Validar acceso

37.2. Query 33: Obtener Turnos por Buque (BuqueId)

37.3.  Guardar en Sesion: Resultado Query 33

37.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones]


38.  ### Listar Turnos Por Usuario Creador (Super Admin, Supervisor, Guia)

38.1. Validar acceso

38.2. Query 34: Obtener Turnos por Usuario Creador  (UsuarioId)

38.3.  Guardar en Sesion: Resultado Query 34

38.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, Observaciones, UsuarioCreadorId, UsuarioCreadorNombre]