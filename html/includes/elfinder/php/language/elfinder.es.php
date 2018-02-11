<?php
/**
* @category RavenNuke 3.0
* @package Core
* @subpackage elFinder
* @version $Id$
* @copyright (c) 2012 Raven Web Services, LLC
* @link http://www.ravennuke.com
* @license http://www.gnu.org/licenses/gpl.html GNU/GPL 3
*/

/*
 * Spanish translation
 * Julián Torres <julian.torres@pabernosmatao.com>
 */

if (!defined('ELFINDER_PATH')) die('Illegal File Access');

$elLanguage = array (
			/********************************** errors **********************************/
			'error'                => 'Error',
			'errUnknown'           => 'Error desconocido.',
			'errUnknownCmd'        => 'Comando desconocido.',
			'errJqui'              => 'Configuración no válida de jQuery UI. deben estar incluidos los componentes selectable, draggable y droppable.',
			'errNode'              => 'elFinder necesita crear elementos DOM.',
			'errURL'               => 'Configuración no válida de elFinder! La opción URL no está configurada.',
			'errAccess'            => 'Acceso denegado.',
			'errConnect'           => 'No se ha podido conectar con el backend.',
			'errAbort'             => 'Conexión cancelada.',
			'errTimeout'           => 'Conexión cancelada por timeout.',
			'errNotFound'          => 'Backend no encontrado.',
			'errResponse'          => 'Respuesta no válida del backend.',
			'errConf'              => 'Configuración no válida del backend .',
			'errJSON'              => 'El módulo PHP JSON no está instalado.',
			'errNoVolumes'         => 'No hay disponibles volúmenes legibles.',
			'errCmdParams'         => 'Parámetros no válidos para el comando %s.',
			'errDataNotJSON'       => 'los datos no estñan en formato JSON.',
			'errDataEmpty'         => 'No hay datos.',
			'errCmdReq'            => 'La petición del backend necesita un nombre de comando.',
			'errOpen'              => 'No se puede abrir %s.',
			'errNotFolder'         => 'El objeto no es una carpeta.',
			'errNotFile'           => 'El objeto no es un archivo.',
			'errRead'              => 'No se puede leer %s.',
			'errWrite'             => 'No se puede escribir en %s.',
			'errPerm'              => 'Permiso denegado.',
			'errLocked'            => '%s está bloqueado y no puede ser renombrado, movido o borrado.',
			'errExists'            => 'Ya existe un archivo llamado %s.',
			'errInvName'           => 'Nombre de archivo no válido.',
			'errFolderNotFound'    => 'Carpeta no encontrada.',
			'errFileNotFound'      => 'Archivo no encontrado.',
			'errTrgFolderNotFound' => 'Carpeta de destino %s no encontrada.',
			'errPopup'             => 'El navegador impide abrir nuevas ventanas. Puede activarlo en las opciones del navegador.',
			'errMkdir'             => 'No se puede crear la carpeta %s.',
			'errMkfile'            => 'No se puede crear el archivo %s.',
			'errRename'            => 'No se puede renombrar %s.',
			'errCopyFrom'          => 'No se permite copiar archivos desde el volumen %s.',
			'errCopyTo'            => 'No se permite copiar archivos al volumen %s.',
			'errUploadCommon'      => 'Error en el envñio.',
			'errUpload'            => 'No se puede subir %s.',
			'errUploadNoFiles'     => 'No hay archivos para subir.',
			'errMaxSize'           => 'El tamaño de los datos excede el máximo permitido.',
			'errFileMaxSize'       => 'El tamaño del archivo excede el máximo permitido.',
			'errUploadMime'        => 'Tipo de archivo no permitidp.',
			'errUploadTransfer'    => 'Error al transferir %s.',
			'errSave'              => 'No se puede guadar %s.',
			'errCopy'              => 'No se puede copiar %s.',
			'errMove'              => 'No se puede mover %s.',
			'errCopyInItself'      => 'No se puede copiar %s into itself.',
			'errRm'                => 'No se puede borrar %s.',
			'errExtract'           => 'No se puede extraer archivos from %s.',
			'errArchive'           => 'No se puede crear el archivo.',
			'errArcType'           => 'Tipo de archivo no soportado.',
			'errNoArchive'         => 'El archivo no es de tipo archivo o es de un tipo no soportado.',
			'errCmdNoSupport'      => 'El backend no soporta este comando.',
			'errReplByChild'       => 'La carpeta “$1” no puede ser reemplazada por un elemento contenido en ella.',
			'errArcSymlinks'       => 'Por razones de seguridad no se pueden descomprimir archivos que contengan symlinks.',
			'errArcMaxSize'        => 'El tamaño del archivo excede el máximo permitido.',

			/******************************* commands names ********************************/
			'cmdarchive'   => 'Crear archivo',
			'cmdback'      => 'Atrás',
			'cmdcopy'      => 'Copiar',
			'cmdcut'       => 'Cortar',
			'cmddownload'  => 'Descargar',
			'cmdduplicate' => 'Duplicar',
			'cmdedit'      => 'Editar archivo',
			'cmdextract'   => 'Extraer elementos del archivo',
			'cmdforward'   => 'Adelante',
			'cmdgetfile'   => 'Seleccionar archivos',
			'cmdhelp'      => 'Acerca de este software',
			'cmdhome'      => 'Inicio',
			'cmdinfo'      => 'Obtener información',
			'cmdmkdir'     => 'Nueva arpeta',
			'cmdmkfile'    => 'Nuevo archivo de texto',
			'cmdopen'      => 'Abrir',
			'cmdpaste'     => 'Pegar',
			'cmdquicklook' => 'Previsualizar',
			'cmdreload'    => 'Recargar',
			'cmdrename'    => 'Cambiar nombre',
			'cmdrm'        => 'Eliminar',
			'cmdsearch'    => 'Buscar archivos',
			'cmdup'        => 'Ir a la carpeta raíz',
			'cmdupload'    => 'Subir archivos',
			'cmdview'      => 'Ver',

			/*********************************** buttons ***********************************/
			'btnClose'  => 'Cerrar',
			'btnSave'   => 'Guardar',
			'btnRm'     => 'Eliminar',
			'btnCancel' => 'Cancelar',
			'btnNo'     => 'No',
			'btnYes'    => 'Sí',

			/******************************** notifications ********************************/
			'ntfopen'     => 'Abrir carpeta',
			'ntffile'     => 'Abrir archivo',
			'ntfreload'   => 'Actualizar contenido de la carpeta',
			'ntfmkdir'    => 'Creando directorio',
			'ntfmkfile'   => 'Creando archivos',
			'ntfrm'       => 'Eliminndo archivos',
			'ntfcopy'     => 'Copiar archivos',
			'ntfmove'     => 'Mover archivos',
			'ntfprepare'  => 'Preparar copia de archivos',
			'ntfrename'   => 'Renombrar archivos',
			'ntfupload'   => 'Subiendo archivos',
			'ntfdownload' => 'Descargando archivos',
			'ntfsave'     => 'Guardar archivos',
			'ntfarchive'  => 'Creando archivo',
			'ntfextract'  => 'Extrayendo elementos del archivo',
			'ntfsearch'   => 'Buscando archivos',
			'ntfsmth'     => 'Haciendo algo >_<',
			'ntfloadimg'  => 'Cargando imagen',

			/************************************ dates **********************************/
			'dateUnknown' => 'desconocida',
			'Today'       => 'Hoy',
			'Yesterday'   => 'Ayer',
			'Jan'         => 'Ene',
			'Feb'         => 'Feb',
			'Mar'         => 'Mar',
			'Apr'         => 'Abr',
			'May'         => 'May',
			'Jun'         => 'Jun',
			'Jul'         => 'Jul',
			'Aug'         => 'Ago',
			'Sep'         => 'Sep',
			'Oct'         => 'Oct',
			'Nov'         => 'Nov',
			'Dec'         => 'Dic',

			/********************************** messages **********************************/
			'confirmReq'      => 'Se necesita confirmación',
			'confirmRm'       => '¿Está seguro de querer eliminar archivos?<br/>Esto no tiene vuelta atrás!',
			'confirmRepl'     => '¿Reemplazar el antigüo archivo con el nuevo?',
			'apllyAll'        => 'Aplicar a todo',
			'name'            => 'Nombre',
			'size'            => 'Tamaño',
			'perms'           => 'Permisos',
			'modify'          => 'Modificado',
			'kind'            => 'Tipo',
			'read'            => 'lectura',
			'write'           => 'escritura',
			'noaccess'        => 'sin acceso',
			'and'             => 'y',
			'unknown'         => 'desconocido',
			'selectall'       => 'Seleccionar todos los archivos',
			'selectfiles'     => 'Seleccionar archivo(s)',
			'selectffile'     => 'Seleccionar primer archivo',
			'selectlfile'     => 'Seleccionar último archivo',
			'viewlist'        => 'ver como lista',
			'viewicons'       => 'Ver como iconos',
			'places'          => 'Lugares',
			'calc'            => 'Calcular',
			'path'            => 'Ruta',
			'aliasfor'        => 'Alias para',
			'locked'          => 'Bloqueado',
			'dim'             => 'Dimensiones',
			'files'           => 'Archivos',
			'folders'         => 'Carpetas',
			'items'           => 'Elementos',
			'yes'             => 'si',
			'no'              => 'no',
			'link'            => 'Enlace',
			'searcresult'     => 'Resultados de la búsqueda',
			'selected'        => 'elementos seleccionados',
			'about'           => 'Acerca',
			'shortcuts'       => 'Accesos directos',
			'help'            => 'Ayuda',
			'webfm'           => 'Administrador de archivos web',
			'ver'             => 'Version',
			'protocol'        => 'versión del protocolo',
			'homepage'        => 'Project home',
			'docs'            => 'Documentación',
			'github'          => 'Fork us on Github',
			'twitter'         => 'Síguenos en Twitter',
			'facebook'        => 'Únete a nostros en Facebook',
			'team'            => 'Equipo',
			'chiefdev'        => 'desarrollador jefe',
			'developer'       => 'desarrollador',
			'contributor'     => 'contribuyente',
			'maintainer'      => 'mantenedor',
			'translator'      => 'traductor',
			'icons'           => 'Iconos',
			'dontforget'      => 'y no olvide traer su toalla',
			'shortcutsof'     => 'Accesos directos desactivados',
			'dropFiles'       => 'Arrastre archivos aquí',
			'or'              => 'o',
			'selectForUpload' => 'Seleccione archivos para subir',
			'moveFiles'       => 'Mover archivos',
			'copyFiles'       => 'Copiar archivos',
			'rmFromPlaces'    => 'Eliminar en sus ubicaciónes',
			'untitled folder' => 'carpeta sin título',
			'untitled archivo.txt' => 'archivo.txt sin título',
			'mode'            => 'Modo',
			'resize'          => 'Redimensionar',
			'crop'            => 'Recortar',

			/********************************** mimetypes **********************************/
			'kindUnknown'     => 'Desconocido',
			'kindFolder'      => 'Carpeta',
			'kindAlias'       => 'Alias',
			'kindAliasBroken' => 'Alias roto',
			// applications
			'kindApp'         => 'Aplicación',
			'kindPostscript'  => 'Documento Postscript',
			'kindMsOffice'    => 'Documento Microsoft Office',
			'kindMsWord'      => 'Documento Microsoft Word',
			'kindMsExcel'     => 'Documento Microsoft Excel',
			'kindMsPP'        => 'Presentación Microsoft Powerpoint',
			'kindOO'          => 'Documento Open Office',
			'kindAppFlash'    => 'Aplicación Flash',
			'kindPDF'         => 'Documento PDF',
			'kindTorrent'     => 'Archivo Bittorrent',
			'kind7z'          => 'Archivo 7z',
			'kindTAR'         => 'Archivo TAR',
			'kindGZIP'        => 'Archivo GZIP',
			'kindBZIP'        => 'Archivo BZIP',
			'kindZIP'         => 'Archivo ZIP',
			'kindRAR'         => 'Archivo RAR',
			'kindJAR'         => 'Archivo Java JAR',
			'kindTTF'         => 'Fuente True Type',
			'kindOTF'         => 'Fuente Open Type',
			'kindRPM'         => 'Paquete RPM',
			// texts
			'kindText'        => 'Documento de texto',
			'kindTextPlain'   => 'Texto plano',
			'kindPHP'         => 'Código PHP',
			'kindCSS'         => 'Hoja de estilo CSS',
			'kindHTML'        => 'Documento HTML',
			'kindJS'          => 'Código Javascript',
			'kindRTF'         => 'Documento RTF',
			'kindC'           => 'C source',
			'kindCHeader'     => 'Código C header',
			'kindCPP'         => 'Código C++',
			'kindCPPHeader'   => 'Código C++ header',
			'kindShell'       => 'Script Unix shell',
			'kindPython'      => 'Código Python',
			'kindJava'        => 'Código Java',
			'kindRuby'        => 'Código Ruby',
			'kindPerl'        => 'Código Perl',
			'kindSQL'         => 'SCódigo QL',
			'kindXML'         => 'Documento XML',
			'kindAWK'         => 'Código AWK source',
			'kindCSV'         => 'Documento CSV (valores separados por comas)',
			'kindDOCBOOK'     => 'Documento Docbook XML',
			// images
			'kindImage'       => 'Imagen',
			'kindBMP'         => 'Imagen BMP',
			'kindJPEG'        => 'Imagen JPEG',
			'kindGIF'         => 'Imagen GIF',
			'kindPNG'         => 'Imagen PNG',
			'kindTIFF'        => 'Imagen TIFF',
			'kindTGA'         => 'Imagen TGA',
			'kindPSD'         => 'Imagen Adobe Photoshop',
			'kindXBITMAP'     => 'Imagen X bitmap',
			'kindPXM'         => 'Imagen Pixelmator',
			// media
			'kindAudio'       => 'Audio media',
			'kindAudioMPEG'   => 'Audio MPEG',
			'kindAudioMPEG4'  => 'Audio MPEG-4',
			'kindAudioMIDI'   => 'Audio MIDI',
			'kindAudioOGG'    => 'Audio Ogg Vorbis',
			'kindAudioWAV'    => 'Audio WAV',
			'AudioPlaylist'   => 'Playlist MP3',
			'kindVideo'       => 'Video media',
			'kindVideoDV'     => 'Película DV',
			'kindVideoMPEG'   => 'Película MPEG',
			'kindVideoMPEG4'  => 'Película MPEG-4',
			'kindVideoAVI'    => 'Película AVI',
			'kindVideoMOV'    => 'Película Quick Time',
			'kindVideoWM'     => 'Película Windows Media',
			'kindVideoFlash'  => 'Película Flash',
			'kindVideoMKV'    => 'Película Matroska MKV',
			'kindVideoOGG'    => 'Película Ogg'
		);