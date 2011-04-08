<?php
$sConnectorPath = _LIB_ABSPATH_ . '/fckeditor/editor/filemanager/connectors/php';
require( $sConnectorPath . '/config.php' ) ;
require( $sConnectorPath . '/util.php' ) ;
require( $sConnectorPath . '/io.php' ) ;
require( $sConnectorPath . '/commands.php' ) ;
require( $sConnectorPath . '/phpcompat.php' ) ;

class Uploadter {
	public static $errNumber = '0';
		
	protected static function FileUpload( $name, $resourceType, $currentFolder, $sCommand ) {
		if ( !isset( $_FILES ) ) {
			global $_FILES;
		}

		$sErrorNumber = '0' ;
		$sFileName = '' ;

		if ( isset( $_FILES[ $name ] ) && !is_null( $_FILES[ $name ]['tmp_name'] ) ) {
			global $Config ;

			$oFile = $_FILES[ $name ] ;

			// Map the virtual path to the local server path.
			$sServerDir = ServerMapFolder( $resourceType, $currentFolder, $sCommand ) ;

			// Get the uploaded file name.
			$sFileName = $oFile['name'] ;
			$sFileName = SanitizeFileName( $sFileName ) ;

			$sOriginalFileName = $sFileName ;

			// Get the extension.
			$sExtension = substr( $sFileName, ( strrpos($sFileName, '.') + 1 ) ) ;
			$sExtension = strtolower( $sExtension ) ;

			if ( isset( $Config['SecureImageUploads'] ) ) {
				if ( ( $isImageValid = IsImageValid( $oFile['tmp_name'], $sExtension ) ) === false ) {
					$sErrorNumber = '202' ;
				}
			}

			if ( isset( $Config['HtmlExtensions'] ) ) {
				if ( !IsHtmlExtension( $sExtension, $Config['HtmlExtensions'] ) &&
				( $detectHtml = DetectHtml( $oFile['tmp_name'] ) ) === true ) {
					$sErrorNumber = '202' ;
				}
			}

			// Check if it is an allowed extension.
			if ( !$sErrorNumber && IsAllowedExt( $sExtension, $resourceType ) ) {
				$iCounter = 0 ;

				while ( true ) {
					$sFilePath = $sServerDir . $sFileName ;

					if ( is_file( $sFilePath ) )
					{
						$iCounter++ ;
						$sFileName = RemoveExtension( $sOriginalFileName ) . '(' . $iCounter . ').' . $sExtension ;
						$sErrorNumber = '201' ;
					}
					else
					{
						move_uploaded_file( $oFile['tmp_name'], $sFilePath ) ;

						if ( is_file( $sFilePath ) )
						{
							if ( isset( $Config['ChmodOnUpload'] ) && !$Config['ChmodOnUpload'] )
							{
								break ;
							}

							$permissions = 0777;

							if ( isset( $Config['ChmodOnUpload'] ) && $Config['ChmodOnUpload'] )
							{
								$permissions = $Config['ChmodOnUpload'] ;
							}

							$oldumask = umask(0) ;
							chmod( $sFilePath, $permissions ) ;
							umask( $oldumask ) ;
						}

						break ;
					}
				}

				if ( file_exists( $sFilePath ) )
				{
					//previous checks failed, try once again
					if ( isset( $isImageValid ) && $isImageValid === -1 && IsImageValid( $sFilePath, $sExtension ) === false )
					{
						@unlink( $sFilePath ) ;
						$sErrorNumber = '202' ;
					}
					else if ( isset( $detectHtml ) && $detectHtml === -1 && DetectHtml( $sFilePath ) === true )
					{
						@unlink( $sFilePath ) ;
						$sErrorNumber = '202' ;
					}
				}
			}
			else
			$sErrorNumber = '202' ;
		}
		else
		$sErrorNumber = '202' ;

		//$sFileUrl = CombinePaths( GetResourceTypePath( $resourceType, $sCommand ) , $currentFolder ) ;
		//$sFileUrl = CombinePaths( $sFileUrl, $sFileName ) ;

		//return $sErrorNumber;
		self::$errNumber = $sErrorNumber;		
		if ( $sErrorNumber == '201' || $sErrorNumber == '0' )
			return $sFileName;
		return false;
	}

	protected static function DeleteFile( $sFileName, $resourceType, $currentFolder, $sCommand ){
		$sServerDir = ServerMapFolder( $resourceType, $currentFolder, $sCommand ) ;		
		$sFileUrl = $sServerDir . $sFileName;			
		if ( is_file( $sFileUrl ) ){			
			return @unlink( $sFileUrl );
		}
		return false;
	}
	
	public static function uploadImage( $name ) {
		$sCommand = 'QuickUpload' ;
		$sCurrentFolder	= GetCurrentFolder() ;
		return self::FileUpload( $name , 'Image', $sCurrentFolder, $sCommand );
	}

	public static function deleteImage( $name ){
		$sCommand = 'QuickUpload' ;
		$sCurrentFolder	= GetCurrentFolder() ;
		return self::DeleteFile( $name , 'Image', $sCurrentFolder, $sCommand );
	}

}
?>