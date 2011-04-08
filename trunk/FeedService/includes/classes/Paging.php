<?php
class Paging {
	public $sName;
	public $sQueryString = '';
	public $sPageSpace = "\n";
	public $sPageTag_Start = '';
	public $sPageTag_End = '';
	public $sPageClass = '';
	public $sPageTitle = 'Chuyen den trang {PAGE}';
	public $sPageNext = '&rsaquo;';
	public $sPageNextClass = '';
	public $sPageNextTitle = 'Chuyen den trang tiep theo';
	public $sPageFirst = '&laquo;';
	public $sPageFirstClass = '';
	public $sPageFirstTitle = 'Chuyen den trang dau tien';
	public $sPageLast = ' &raquo;';
	public $sPageLastClass = '';
	public $sPageLastTitle = 'Chuyen den trang cuoi cung';
	public $sPagePrevious = '&lsaquo;';
	public $sPagePreviousClass = '';
	public $sPagePreviousTitle = 'Chuyen den trang truoc do';
	public $sPageEllipsis = '...';
	public $sPageEllipsisClass = 'dotdot';
	public $sCurrentPageTag_Start = '';
	public $sCurrentPageTag_End = '';
	public $sCurrentPageClass = '';
	public $nTotalRow;
	public $nResultRow;
	public $nDisplayPage;
	private $nCurrentPage = 0;
	private $sOldPageQueryString = '';
	public $sPostfix = '';
	public static $instances = NULL;	public $customlink = false;
	public function __construct( $name, $resultrow, $totalrow, $displaypage = 9 ){
		$this->sName = $name;
		$this->nTotalRow = $totalrow;
		$this->nResultRow = $resultrow;
		$this->nDisplayPage = $displaypage;
	}

	public function __toString(){
		$sPager = $this->getPagerFirst() . $this->sPageSpace;
		$sPager .= $this->getPagerPrevious() . $this->sPageSpace;
		$sPager .= $this->getPagerList() . $this->sPageSpace;
		$sPager .= $this->getPagerEllipsis() . $this->sPageSpace;
		$sPager .= $this->sPageSpace . $this->getPagerNext();
		$sPager .= $this->sPageSpace . $this->getPagerLast();
		return $sPager;
	}

	public function getTotalPage(){
		if ( $this->nResultRow == 0 ) return 0;
		return ceil( $this->nTotalRow / $this->nResultRow );
	}

	public function getDisplayPage(){
		if ( $this->nDisplayPage > $this->getTotalPage() ){
			return $this->getTotalPage();
		}
		return $this->nDisplayPage;
	}

	public function getCurrentPagerNum(){
		$nCurrent = 1;

		if ( !empty( $_GET[ $this->sName ] ) ){
			$nCurrent = $_GET[ $this->sName ];
		}

		return $nCurrent;
	}
	//Cac ham theo du lieju
	public function getResultRowStart(){
		$nStart = ( $this->getCurrentPagerNum() - 1 ) * $this->nResultRow;
		return $nStart;
	}


	//Cac ham hien thi
	public function getPagerEllipsis(){
		$nSpacePage = (int)( $this->getDisplayPage() / 2 );
		if ( $this->getTotalPage() > $this->getDisplayPage() && $this->getCurrentPagerNum() < ( $this->getTotalPage() - $nSpacePage ) ){
			return '<span class="' . $this->sPageEllipsisClass . '">' . $this->sPageEllipsis . '</span>';
		}
	}

	public function getPagerList(){
		$nCurrent = $this->getCurrentPagerNum();
		$nSpacePage = (int)( $this->getDisplayPage() / 2 );
		//Lay trang bat dau
		$nStartPage = 1;
		if ( ( $nCurrent > $nSpacePage ) //Nam ngoai nSpacePage trang dau
		&& ( ( $nCurrent < ( $this->getTotalPage() - $nSpacePage ) ) ) //Nam ngoai nDisplayPage cuoi
		){
			$nStartPage = $nCurrent - $nSpacePage;
		}else if ( $nCurrent >=  ( $this->getTotalPage() - $nSpacePage ) ){
			$nStartPage = $this->getTotalPage() - $this->getDisplayPage() + 1;
		}

		//Lay trang ket thuc
		$nEndPage = $nStartPage + $this->getDisplayPage() - 1;

		if ( $nEndPage > $this->getTotalPage() ){
			$nEndPage = $this->getTotalPage();
		}
		$sPagerList = '';
		//echo $nStartPage . ' - ' . $nEndPage;
		for ( $i = $nStartPage; $i <= $nEndPage; $i++ ){

			if ( $i == $nCurrent ){
				$sPagerList .= $this->getCurrentPage( $i );
			}else{
				$sPagerList .= $this->getPage( $i );
			}

			if ( $i != $nEndPage ){
				$sPagerList .= $this->sPageSpace;
			}

		}//for

		return $sPagerList;
	}

	public function getPagerNext(){
		$sPagerNext = '';

		if ( $this->getCurrentPagerNum() < $this->getTotalPage() ){
			$nNext = $this->getCurrentPagerNum() + 1;
			$sPagerNext = '<a href="' . $this->getPageLink( $nNext ) . '" title="' . $this->getPageTitle( $nNext, $this->sPageNextTitle ) . '" ' . $this->getPageClass( $nNext, $this->sPageNextClass ) . ' >' . $this->sPageNext . '</a>';
		}
		return $sPagerNext;
	}

	public function getPagerPrevious(){
		$sPagerPrev = '';

		if ( $this->getCurrentPagerNum() > 1 ){
			$nPrev = $this->getCurrentPagerNum() - 1;
			$sPagerPrev = '<a href="' . $this->getPageLink( $nPrev ) . '" title="' . $this->getPageTitle( $nPrev, $this->sPagePreviousTitle ) . '" ' . $this->getPageClass( $nPrev, $this->sPagePreviousClass ) . ' >' . $this->sPagePrevious . '</a>';
		}

		return $sPagerPrev;
	}

	public function getPagerFirst(){
		$sPagerFirst = '';

		if ( $this->getCurrentPagerNum() > 1 ){
			$nFirst = 1;
			$sPagerFirst = '<a href="' . $this->getPageLink( $nFirst ) . '" title="' . $this->getPageTitle( $nFirst, $this->sPageFirstTitle ) . '" ' . $this->getPageClass( $nFirst, $this->sPageFirstClass ) . ' >' . $this->sPageFirst . '</a>';
		}

		return $sPagerFirst;
	}

	public function getPagerLast(){
		$sPagerLast = '';

		if ( $this->getCurrentPagerNum() < $this->getTotalPage() ){
			$nLast = $this->getTotalPage();
			$sPagerLast = '<a href="' . $this->getPageLink( $nLast ) . '" title="' . $this->getPageTitle( $nLast, $this->sPageLastTitle ) . '" ' . $this->getPageClass( $nLast, $this->sPageLastClass ) . ' >' . $this->sPageLast . '</a>';
		}
		return $sPagerLast;
	}
	//Current Page
	protected function getCurrentPageClass( $page ){
		$sCurrentPageClass = '';

		if ( $this->sCurrentPageClass != '' ){
			$sCurrentPageClass = 'class="' . $this->sCurrentPageClass . '"';
		}
		return $sCurrentPageClass;
	}

	protected function getCurrentPage( $page ){
		$sPage =  '<span ' . $this->getCurrentPageClass( $page ) . '>' . $this->sCurrentPageTag_Start . $page . $this->sCurrentPageTag_End . '</span>';
		return $sPage;
	}

	//Page
	protected function getPageTitle( $page, $title ){
		return str_replace( '{PAGE}', $page, $title );
	}

	protected function getPageClass( $page, $class ){
		$sPageClass = '';
		if ( $class != '' ){
			$sPageClass = 'class="' . $class . '"';
		}
		return $sPageClass;
	}

	protected function getPageLink( $page ){	    	    if ($this->customlink == false){
    		$sQS = '';
    		foreach ( $_GET as $name => $value ){
    			if ( $name != $this->sName ){
    				if ( $sQS == '' ){
    					$sQS = $name . '=' . $value;
    				}else{
    					$sQS .= '&' . $name . '=' . $value;
    				}
    			}
    		}//foreach    
    		if ( $sQS == '' ){
    			if ( $this->sQueryString != '' ){
    				$sQS = '?' . $this->sQueryString . '&';
    			}else{
    				$sQS = '?';
    			}
    		}else{
    			if ( $this->sQueryString != '' ){
    				$sQS = '?' . $sQS . '&' . $this->sQueryString . '&';
    			}else{
    				$sQS = '?' . $sQS . '&';
    			}
    		}    		
    		return $_SERVER[ 'PHP_SELF'] . $sQS . $this->sName . '=' . $page . $this->sPostfix;	    }else{	        return  $this->customlink . '&' . $this->sName . '=' . $page . $this->sPostfix;	    }
	}

	protected function getPage( $page ){
		$sPage = '<a href="' . $this->getPageLink( $page ) . '" ' . $this->getPageClass( $page, $this->sPageClass ) . ' title="' . $this->getPageTitle( $page, $this->sPageTitle ) . '" >'
		 . $this->sPageTag_Start . $page . $this->sPageTag_End
		 . '</a>';
		return $sPage;
	}}?>