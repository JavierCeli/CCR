<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MDSFApiResponse;
use App\Models\Acceso;
use App\Models\Formulario;

use Illuminate\Support\Facades\DB;

class AccesoController extends Controller
{

    public function show_all(){
        $respuesta = new MDSFApiResponse();
        
       $query_int = DB::connection('mysql')
        ->select("SELECT a.id AS id_alerta, 
        a.comuna_fk AS comuna,
        c.nombre AS region,
        a.nombre AS nombre_persona, 
        a.run AS run_persona, 
        a.fono AS fono_persona, 
        a.email AS email_persona, 
        a.sexo_persona AS sexo_beneficiario, 
        a.rango_etario AS rango_etario_beneficiario, 
        a.discapacidad AS discapacidad_beneficiario, 
        a.atencion AS tipo_atencion_beneficiario, 
        a.mojada_desabrigada AS mojada_beneficiario, 
        a.estructura AS estructura, 
        a.direccion AS direccion,
        a.coord_x AS coodenada_y,
        a.coord_y AS coordenada_x,
        a.punto_referencia AS punto_refencia, 
        a.comentario AS  comentario, 
        a.comentario_coordinador AS comentario_coordinador, 
        a.tipo AS tipo_alerta, 
        a.estado AS estado_alerta, 
        a.created_at AS fecha_creacion, 
        a.updated_at AS fecha_modificacion, 
        a.vigencia AS vigencia, 
        a.nombrepsc AS nombre_psc
        FROM 
        codigoazul.ca01_alertas a
        LEFT JOIN l02_comuna b ON b.id = a.comuna_fk
        LEFT JOIN l01_region c ON c.id = b.region_fk
        WHERE a.id >= 29664");
        if($query_int!=null)
        {
            foreach ($query_int as $info)
            {
                $id_alerta=$info->id_alerta;
                $nombre=$info->Descripcion;
                $porcentaje=$info->Porcentaje;

                $respuesta->data[] = ["id_alerta" => $info->$id_alerta, 
                "comuna" => $info->$comuna, 
                "region" => $info->$region,
                "nombre_persona" => $info->$nombre_persona,
                "run_persona" => $info->$run_persona,
                "fono_persona" => $info->$fono_persona,
                "email_persona" => $info->$email_persona,
                "sexo_beneficiario" => $info->$sexo_beneficiario,
                "rango_etario_beneficiario" => $info->$rango_etario_beneficiario,
                "discapacidad_beneficiario" => $info->$discapacidad_beneficiario,
                "tipo_atencion_beneficiario" => $info->$tipo_atencion_beneficiario,
                "mojada_beneficiario" => $info->$mojada_beneficiario,
                "estructura" => $info->$estructura,
                "direccion" => $info->$direccion,
                "coodenada_y" => $info->$coodenada_y,
                "coordenada_x" => $info->$coordenada_x,
                "punto_refencia" => $info->$punto_refencia,
                "comentario" => $info->$comentario,
                "comentario_coordinador" => $info->$comentario_coordinador,
                "tipo_alerta" => $info->$tipo_alerta,
                "estado_alerta" => $info->$estado_alerta,
                "fecha_creacion" => $info->$fecha_creacion,
                "fecha_modificacion" => $info->$fecha_modificacion,
                "vigencia" => $info->$vigencia,
                "nombre_psc" => $info->$nombre_psc,
                "region" => $info->$region];
            }
        }

        return $respuesta->json();

    }

    
}
