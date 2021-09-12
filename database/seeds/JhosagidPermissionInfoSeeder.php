<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Permission\Models\Role;
use App\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class JhosagidPermissionInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //limpiar las tablas antes de llenarlas (truncate)
        //primero desactivamos las restricciones de llaves foranias
        DB::statement("SET foreign_key_checks=0");
        //usamos DB para porder truncar las tablas que no tienen un modelo creado
        DB::table('role_user')->truncate();
        DB::table('permission_role')->truncate();
        //hacemos truncate a las tablas que tienen modelos pero con eloquent
        Permission::truncate();
        Role::truncate();
        //ahor habilitamos los freignKey
        DB::statement("SET foreign_key_checks=1");

        //user admin
        $superuseradmin = User::where('email', 'jhosagid77@gmail.com')->first();
        //buscamos si existe ese correo enla tabla user para poder crear el registro sin duplicar
        if($superuseradmin){
            $superuseradmin->delete();
        }

        $superuseradmin = User::create([
            'name' => 'Jhonny Sagid Pirela Pineda',
            'email' => 'jhosagid77@gmail.com',
            'password' => Hash::make('jhosagid')
        ]);


        //user admin
        $useradmin = User::where('email', 'admin@admin.com')->first();
        //buscamos si existe ese correo enla tabla user para poder crear el registro sin duplicar
        if($useradmin){
            $useradmin->delete();
        }

        $useradmin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin')
        ]);

        //creamos nuestro rol admin
        //rol admin
        $roladmin=Role::create([
            'name'=>'Admin',
            'slug'=>'admin',
            'description'=>'Administrator',
            'full-access'=>'yes'
        ]);


        //creamos nuestro rol Registered User
        //rol Registered User
        $roluser=Role::create([
            'name'=>'Registered User',
            'slug'=>'registereduser',
            'description'=>'Registered User',
            'full-access'=>'no'
        ]);

        //tabla role_user
        //pasar rol unico al usuario relacionamos dos tablas admin y usuario
        $superuseradmin->roles()->sync([$roladmin->id]);
        $useradmin->roles()->sync([$roladmin->id]);

        //tabla role_permission
        //Permission
        $permission_all = [];

        //permission role
        $permission = Permission::create([
            'name'=>'List role',
            'slug'=>'role.index',
            'description'=>'A user can list role'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show role',
            'slug'=>'role.show',
            'description'=>'A user can see role'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Create role',
            'slug'=>'role.create',
            'description'=>'A user can create role'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit role',
            'slug'=>'role.edit',
            'description'=>'A user can edit role'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy role',
            'slug'=>'role.destroy',
            'description'=>'A user can destroy role'
        ]);

        $permission_all[] = $permission->id;





        //permission user
        $permission = Permission::create([
            'name'=>'List user',
            'slug'=>'user.index',
            'description'=>'A user can list user'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show user',
            'slug'=>'user.show',
            'description'=>'A user can see user'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit user',
            'slug'=>'user.edit',
            'description'=>'A user can edit user'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy user',
            'slug'=>'user.destroy',
            'description'=>'A user can destroy user'
        ]);

        $permission_all[] = $permission->id;


        //permission ventas
        $permission = Permission::create([
            'name'=>'List ventas',
            'slug'=>'venta.index',
            'description'=>'A user can list ventas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show ventas',
            'slug'=>'venta.show',
            'description'=>'A user can see ventas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Create ventas',
            'slug'=>'venta.create',
            'description'=>'A user can create ventas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit ventas',
            'slug'=>'venta.edit',
            'description'=>'A user can edit ventas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy ventas',
            'slug'=>'venta.destroy',
            'description'=>'A user can destroy ventas'
        ]);

        $permission_all[] = $permission->id;

        //permission transferencias
        $permission = Permission::create([
            'name'=>'List transferencias',
            'slug'=>'transferencia.index',
            'description'=>'A user can list transferencias'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show transferencias',
            'slug'=>'transferencia.show',
            'description'=>'A user can see transferencias'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Create transferencias',
            'slug'=>'transferencia.create',
            'description'=>'A user can create transferencias'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit transferencias',
            'slug'=>'transferencia.edit',
            'description'=>'A user can edit transferencias'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy transferencias',
            'slug'=>'transferencia.destroy',
            'description'=>'A user can destroy transferencias'
        ]);

        $permission_all[] = $permission->id;

        //permission tasa
        $permission = Permission::create([
            'name'=>'List tasas',
            'slug'=>'tasa.index',
            'description'=>'A user can list tasas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show tasas',
            'slug'=>'tasa.show',
            'description'=>'A user can see tasas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Create tasas',
            'slug'=>'tasa.create',
            'description'=>'A user can create tasas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit tasas',
            'slug'=>'tasa.edit',
            'description'=>'A user can edit tasas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy tasas',
            'slug'=>'tasa.destroy',
            'description'=>'A user can destroy tasas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Ver registro de Efectivo Venta en tasa',
            'slug'=>'tasacampoefectivoventa.ver',
            'description'=>'A user see campo EfectivoVenta de tasa'
        ]);

        $permission_all[] = $permission->id;

        //permission reportes
        $permission = Permission::create([
            'name'=>'List reportes',
            'slug'=>'reporte.index',
            'description'=>'A user can list reportes'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show reportes',
            'slug'=>'reporte.show',
            'description'=>'A user can see reportes'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Create reportes',
            'slug'=>'reporte.create',
            'description'=>'A user can create reportes'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit reportes',
            'slug'=>'reporte.edit',
            'description'=>'A user can edit reportes'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy reportes',
            'slug'=>'reporte.destroy',
            'description'=>'A user can destroy reportes'
        ]);

        $permission_all[] = $permission->id;

        //permission proveedor
        $permission = Permission::create([
            'name'=>'List proveedores',
            'slug'=>'proveedore.index',
            'description'=>'A user can list proveedores'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show proveedores',
            'slug'=>'proveedore.show',
            'description'=>'A user can see proveedores'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Create proveedores',
            'slug'=>'proveedore.create',
            'description'=>'A user can create proveedores'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit proveedores',
            'slug'=>'proveedore.edit',
            'description'=>'A user can edit proveedores'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy proveedores',
            'slug'=>'proveedore.destroy',
            'description'=>'A user can destroy proveedores'
        ]);

        $permission_all[] = $permission->id;

        //permission ingresos
        $permission = Permission::create([
            'name'=>'List ingresos',
            'slug'=>'ingreso.index',
            'description'=>'A user can list ingresos'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show ingresos',
            'slug'=>'ingreso.show',
            'description'=>'A user can see ingresos'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Create ingresos',
            'slug'=>'ingreso.create',
            'description'=>'A user can create ingresos'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit ingresos',
            'slug'=>'ingreso.edit',
            'description'=>'A user can edit ingresos'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy ingresos',
            'slug'=>'ingreso.destroy',
            'description'=>'A user can destroy ingresos'
        ]);

        $permission_all[] = $permission->id;

        //permission clientes
        $permission = Permission::create([
            'name'=>'List clientes',
            'slug'=>'cliente.index',
            'description'=>'A user can list clientes'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show clientes',
            'slug'=>'cliente.show',
            'description'=>'A user can see clientes'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Create clientes',
            'slug'=>'cliente.create',
            'description'=>'A user can create clientes'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit clientes',
            'slug'=>'cliente.edit',
            'description'=>'A user can edit clientes'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy clientes',
            'slug'=>'cliente.destroy',
            'description'=>'A user can destroy clientes'
        ]);

        $permission_all[] = $permission->id;

        //permission categorias
        $permission = Permission::create([
            'name'=>'List categorias',
            'slug'=>'categoria.index',
            'description'=>'A user can list categorias'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show categorias',
            'slug'=>'categoria.show',
            'description'=>'A user can see categorias'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Create categorias',
            'slug'=>'categoria.create',
            'description'=>'A user can create categorias'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit categorias',
            'slug'=>'categoria.edit',
            'description'=>'A user can edit categorias'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy categorias',
            'slug'=>'categoria.destroy',
            'description'=>'A user can destroy categorias'
        ]);

        $permission_all[] = $permission->id;

        //permission cajas
        $permission = Permission::create([
            'name'=>'List cajas',
            'slug'=>'caja.index',
            'description'=>'A user can list cajas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show cajas',
            'slug'=>'caja.show',
            'description'=>'A user can see cajas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Create cajas',
            'slug'=>'caja.create',
            'description'=>'A user can create cajas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit cajas',
            'slug'=>'caja.edit',
            'description'=>'A user can edit cajas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy cajas',
            'slug'=>'caja.destroy',
            'description'=>'A user can destroy cajas'
        ]);

        $permission_all[] = $permission->id;

        //permission articulos
        $permission = Permission::create([
            'name'=>'List articulos',
            'slug'=>'articulo.index',
            'description'=>'A user can list articulos'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Show articulos',
            'slug'=>'articulo.show',
            'description'=>'A user can see articulos'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Create articulos',
            'slug'=>'articulo.create',
            'description'=>'A user can create articulos'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit articulos',
            'slug'=>'articulo.edit',
            'description'=>'A user can edit articulos'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Destroy articulos',
            'slug'=>'articulo.destroy',
            'description'=>'A user can destroy articulos'
        ]);

        $permission_all[] = $permission->id;

        // $permission = Permission::create([
        //     'name'=>'Create user',
        //     'slug'=>'user.create',
        //     'description'=>'A user can create user'
        // ]);

        // $permission_all[] = $permission->id;

       //tabla permission_role
       //con esta instruccion creamos los permisos del admin
       //pero como le pasamos full-access yes ya el admin tiene todos los permisos
       //asignado por defecto
       //$roladmin->permissions()->sync($permission_all);

       //creamos el permiso para que el admin pueda ver los registros de todos

       $permission = Permission::create([
        'name'=>'Show own user',
        'slug'=>'userown.show',
        'description'=>'A user can see own user'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Edit own user',
            'slug'=>'userown.edit',
            'description'=>'A user can edit own user'
        ]);

        $permission_all[] = $permission->id;



        //creamos permisos para poder ver sus propias ventas
        $permission = Permission::create([
            'name'=>'Show own ventas',
            'slug'=>'ventaown.show',
            'description'=>'A user can see own ventas'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Edit own ventas',
                'slug'=>'ventaown.edit',
                'description'=>'A user can edit own ventas'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'delete own ventas',
                'slug'=>'ventaown.destroy',
                'description'=>'A user can delete own ventas'
            ]);

            $permission_all[] = $permission->id;

        //creamos permisos para poder ver sus propias transferencias
        $permission = Permission::create([
            'name'=>'Show own transferencias',
            'slug'=>'transferenciaown.show',
            'description'=>'A user can see own transferencias'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Edit own transferencias',
                'slug'=>'transferenciaown.edit',
                'description'=>'A user can edit own transferencias'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'delete own transferencias',
                'slug'=>'transferenciaown.destroy',
                'description'=>'A user can delete own transferencias'
            ]);

            $permission_all[] = $permission->id;

            //creamos permisos para poder ver sus propias tasas
        $permission = Permission::create([
            'name'=>'Show own tasas',
            'slug'=>'tasaown.show',
            'description'=>'A user can see own tasas'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Edit own tasas',
                'slug'=>'tasaown.edit',
                'description'=>'A user can edit own tasas'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'delete own tasas',
                'slug'=>'tasaown.destroy',
                'description'=>'A user can delete own tasas'
            ]);

            $permission_all[] = $permission->id;

            //creamos permisos para poder ver sus propias reportes
        $permission = Permission::create([
            'name'=>'Show own reportes',
            'slug'=>'reporteown.show',
            'description'=>'A user can see own reportes'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Edit own reportes',
                'slug'=>'reporteown.edit',
                'description'=>'A user can edit own reportes'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'delete own reportes',
                'slug'=>'reporteown.destroy',
                'description'=>'A user can delete own reportes'
            ]);

            $permission_all[] = $permission->id;

            //creamos permisos para poder ver sus propias proveedores
        $permission = Permission::create([
            'name'=>'Show own proveedores',
            'slug'=>'proveedorown.show',
            'description'=>'A user can see own proveedores'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Edit own proveedores',
                'slug'=>'proveedorown.edit',
                'description'=>'A user can edit own proveedores'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'delete own proveedores',
                'slug'=>'proveedorown.destroy',
                'description'=>'A user can delete own proveedores'
            ]);

            $permission_all[] = $permission->id;

            //creamos permisos para poder ver sus propias ingresos
        $permission = Permission::create([
            'name'=>'Show own ingresos',
            'slug'=>'ingresoown.show',
            'description'=>'A user can see own ingresos'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Edit own ingresos',
                'slug'=>'ingresoown.edit',
                'description'=>'A user can edit own ingresos'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'delete own ingresos',
                'slug'=>'ingresoown.destroy',
                'description'=>'A user can delete own ingresos'
            ]);

            $permission_all[] = $permission->id;

            //creamos permisos para poder ver sus propias clientes
        $permission = Permission::create([
            'name'=>'Show own clientes',
            'slug'=>'clienteown.show',
            'description'=>'A user can see own clientes'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Edit own clientes',
                'slug'=>'clienteown.edit',
                'description'=>'A user can edit own clientes'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'delete own clientes',
                'slug'=>'clienteown.destroy',
                'description'=>'A user can delete own clientes'
            ]);

            $permission_all[] = $permission->id;

            //creamos permisos para poder ver sus propias categorias
        $permission = Permission::create([
            'name'=>'Show own categorias',
            'slug'=>'categoriaown.show',
            'description'=>'A user can see own categorias'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Edit own categorias',
                'slug'=>'categoriaown.edit',
                'description'=>'A user can edit own categorias'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'delete own categorias',
                'slug'=>'categoriaown.destroy',
                'description'=>'A user can delete own categorias'
            ]);

            $permission_all[] = $permission->id;


            //creamos permisos para poder ver sus propias cajas
        $permission = Permission::create([
            'name'=>'Show own cajas',
            'slug'=>'cajaown.show',
            'description'=>'A user can see own cajas'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Edit own cajas',
                'slug'=>'cajaown.edit',
                'description'=>'A user can edit own cajas'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'delete own cajas',
                'slug'=>'cajaown.destroy',
                'description'=>'A user can delete own cajas'
            ]);

            $permission_all[] = $permission->id;

            //creamos permisos para poder ver sus propias articulos
            $permission = Permission::create([
            'name'=>'Show own articulos',
            'slug'=>'articuloown.show',
            'description'=>'A user can see own articulos'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Edit own articulos',
                'slug'=>'articuloown.edit',
                'description'=>'A user can edit own articulos'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'delete own articulos',
                'slug'=>'articuloown.destroy',
                'description'=>'A user can delete own articulos'
            ]);

            $permission_all[] = $permission->id;

             //creamos permisos para poder ver el menu Ventas
             $permission = Permission::create([
                'name'=>'Boton Ventas',
                'slug'=>'boton.ventas',
                'description'=>'A see menu venta'
                ]);

            $permission_all[] = $permission->id;

            //Creamos los sub-menu de ventas Botones

            $permission = Permission::create([
                'name'=>'Boton Clientes',
                'slug'=>'boton.cliente',
                'description'=>'A see bub-menu cliente belongs to venta'
                ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Boton Venta',
                'slug'=>'boton.venta',
                'description'=>'A see bub-menu venta belongs to venta'
                ]);

                $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Boton Tasa',
                'slug'=>'boton.tasa',
                'description'=>'A see bub-menu tasa belongs to venta'
                ]);

                $permission_all[] = $permission->id;


            //creamos permisos para poder ver el menu Compras
            $permission = Permission::create([
                'name'=>'Boton compras',
                'slug'=>'boton.compras',
                'description'=>'A see menu compras'
            ]);

            $permission_all[] = $permission->id;

            //Creamos los sub-menu de compras Botones

            $permission = Permission::create([
                'name'=>'Boton Proveedor',
                'slug'=>'boton.proveedor',
                'description'=>'A see bub-menu proveedor belongs to Compras'
                ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Boton Ingreso',
                'slug'=>'boton.ingreso',
                'description'=>'A see bub-menu ingresos belongs to Compras'
                ]);

                $permission_all[] = $permission->id;


            //creamos permisos para poder ver el menu Almacen

            $permission = Permission::create([
                'name'=>'Boton Almacen',
                'slug'=>'boton.almacen',
                'description'=>'A see menu Almacen'
            ]);

            $permission_all[] = $permission->id;

            //Creamos los sub-menu de Categorías Botones

            $permission = Permission::create([
                'name'=>'Boton Categorías',
                'slug'=>'boton.categoria',
                'description'=>'A see menu Categoría belongs to Almacen'
                ]);

                $permission_all[] = $permission->id;


            $permission = Permission::create([
                'name'=>'Boton Artículos',
                'slug'=>'boton.articulos',
                'description'=>'A see bub-menu artículos belongs to Almacen'
                ]);

                $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Boton Transacciones',
                'slug'=>'boton.transacciones',
                'description'=>'A see bub-menu transacciones belongs to Almacen'
                ]);

                $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Menu Transacciones',
                'slug'=>'menu.transactions',
                'description'=>'A user see menu transactions'
            ]);

            $permission_all[] = $permission->id;

                //Creamos los sub-sub-menu de Transacciones sub-menu
                $permission = Permission::create([
                    'name'=>'Boton Transferencias',
                    'slug'=>'boton.transferencias',
                    'description'=>'A see bub-menu transferencias belongs to transferencias thas belongs to Almacen'
                    ]);

                    $permission_all[] = $permission->id;

                $permission = Permission::create([
                    'name'=>'Boton Cargos',
                    'slug'=>'boton.cargos',
                    'description'=>'A see bub-menu cargos belongs to transferencias thas belongs to Almacen'
                    ]);

                    $permission_all[] = $permission->id;

                $permission = Permission::create([
                    'name'=>'Boton Descargos',
                    'slug'=>'boton.descargos',
                    'description'=>'A see bub-menu descargos belongs to transferencias thas belongs to Almacen'
                    ]);

                    $permission_all[] = $permission->id;




            //creamos permisos para poder ver el menu Reportes
            $permission = Permission::create([
                'name'=>'Boton repoReportesrtes',
                'slug'=>'boton.reportes',
                'description'=>'A see menu Reportes'
            ]);

            $permission_all[] = $permission->id;

            //Creamos los sub-menu de Reportes Botones
            $permission = Permission::create([
                'name'=>'Boton Artículos Vendidos',
                'slug'=>'boton.articulosVendidos',
                'description'=>'A see bub-menu Artículos Vendidos belongs to Reportes'
                ]);

                $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Boton Planilla Inventario',
                'slug'=>'boton.planillaInventario',
                'description'=>'A see bub-menu Planilla Inventario belongs to Reportes'
                ]);

                $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Boton Lista de Precios',
                'slug'=>'boton.listaPrecios',
                'description'=>'A see bub-menu Lista de Precios belongs to Reportes'
                ]);

                $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Boton Reporte General',
                'slug'=>'boton.reporteGeneral',
                'description'=>'A see bub-menu Reporte General belongs to Reportes'
                ]);

                $permission_all[] = $permission->id;


            $permission = Permission::create([
                'name'=>'Boton Reporte General Compras',
                'slug'=>'boton.reporteGeneralCompras',
                'description'=>'A see bub-menu Reporte General Compras belongs to Reportes'
                ]);

                $permission_all[] = $permission->id;


            //Creamos los sub-menu de Sistema Botones
            $permission = Permission::create([
                'name'=>'Boton sistema',
                'slug'=>'boton.sistema',
                'description'=>'A see menu sistema'
            ]);

            $permission_all[] = $permission->id;

            //Creamos los sub-menu de Sistema Botones
            $permission = Permission::create([
                'name'=>'Boton Role',
                'slug'=>'boton.role',
                'description'=>'A see bub-menu Role belongs to Sistema'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Boton User',
                'slug'=>'boton.user',
                'description'=>'A see bub-menu User belongs to Sistema'
            ]);

            $permission_all[] = $permission->id;


            //Creamos otros permisos
            $permission = Permission::create([
                'name'=>'Caja costo',
                'slug'=>'cajacosto.show',
                'description'=>'A see caja costo belongs to Reporte Caja'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Ver Datos Ventas',
                'slug'=>'cajadatosventas.show',
                'description'=>'A user see report caja Datos Ventas belongs to Reporte Caja'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Ver Datos Articulos',
                'slug'=>'cajadatosarticulos.show',
                'description'=>'A user see report caja Datos Articulos belongs to Reporte Caja'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Ver Total de las ventas',
                'slug'=>'cajatotalventa.show',
                'description'=>'A user see report caja Total Venta belongs to Reporte Caja'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Ver Precio costo',
                'slug'=>'cajapreciocosto.show',
                'description'=>'A user see report caja Precio Costo belongs to Reporte Caja'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Ver Utilidad',
                'slug'=>'cajautilidad.show',
                'description'=>'A user see report caja Utilidad belongs to Reporte Caja'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Ver Totales',
                'slug'=>'cajatotales.show',
                'description'=>'A user see report caja Totales belongs to Reporte Caja'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Ver Datos Cargos',
                'slug'=>'cargos.index',
                'description'=>'A user see transaction cargos belongs to Transacciones Cargos'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Ver Datos Cargos detallados',
                'slug'=>'cargos.show',
                'description'=>'A user see transaction cargos show belongs to Transacciones Cargos'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Eliminar Datos Cargos detallados',
                'slug'=>'cargos.destroy',
                'description'=>'A user see transaction cargos destroy belongs to Transacciones Cargos'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Crear Cargos',
                'slug'=>'cargos.create',
                'description'=>'A user create cargos'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Ver Datos Descargos',
                'slug'=>'descargos.index',
                'description'=>'A user see transaction descargos'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Ver Datos Descargos detallados',
                'slug'=>'descargos.show',
                'description'=>'A user see transaction descargos show'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Eliminar Datos Descargos detallados',
                'slug'=>'descargos.destroy',
                'description'=>'A user see transaction descargos destroy'
            ]);

            $permission_all[] = $permission->id;

            $permission = Permission::create([
                'name'=>'Crear Descargos',
                'slug'=>'descargos.create',
                'description'=>'A user create descargos'
            ]);

            $permission_all[] = $permission->id;






        }
}
