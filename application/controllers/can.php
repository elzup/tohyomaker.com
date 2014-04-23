<?php

class Can extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function Index()
	{
		$meta = new Metaobj();
		$meta->setup_make();
		$this->load->view('head', array('meta' => $meta));
		$iconnames = explode(',', 'glass,music,search,envelope,heart,star,star-empty,user,film,th-large,th,th-list,ok,remove,zoom-in,zoom-out,off,signal,cog,trash,home,file,time,road,download-alt,download,upload,inbox,play-circle,repeat,refresh,list-alt,lock,flag,headphones,volume-off,volume-down,volume-up,qrcode,barcode,tag,tags,book,bookmark,print,camera,font,bold,italic,text-height,text-width,align-left,align-center,align-right,align-justify,list,indent-left,indent-right,facetime-video,picture,pencil,map-marker,adjust,tint,edit,share,check,move,step-backward,fast-backward,backward,play,pause,stop,forward,fast-forward,step-forward,eject,chevron-left,chevron-right,plus-sign,minus-sign,remove-sign,ok-sign,question-sign,info-sign,screenshot,remove-circle,ok-circle,ban-circle,arrow-left,arrow-right,arrow-up,arrow-down,share-alt,resize-full,resize-small,plus,minus,asterisk,exclamation-sign,gift,leaf,fire,eye-open,eye-close,warning-sign,plane,calendar,random,comment,magnet,chevron-up,chevron-down,retweet,shopping-cart,folder-close,folder-open,resize-vertical,resize-horizontal,hdd,bullhorn,bell,certificate,thumbs-up,thumbs-down,hand-right,hand-left,hand-up,hand-down,circle-arrow-right,circle-arrow-left,circle-arrow-up,circle-arrow-down,globe,wrench,tasks,filter,briefcase,fullscreen');
		echo '<pre>';
		foreach ($iconnames as $iconname) {
			echo tag_icon('glyphicon glyphicon-'. $iconname). ' : ' . $iconname . PHP_EOL;
		}

		echo '--------------\n';
		$iconnames = explode(',', 'cloud-download,cloud-upload,lightbulb,exchange,bell-alt,file-alt,beer,coffee,food,fighter-jet,user-md,stethoscope,suitcase,building,hospital,ambulance,medkit,h-sign,plus-sign-alt,spinner,angle-left,angle-right,angle-up,angle-down,double-angle-left,double-angle-right,double-angle-up,double-angle-down,circle-blank,circle,desktop,laptop,tablet,mobile-phone,quote-left,quote-right,reply,github-alt,folder-close-alt,folder-open-alt');
		foreach ($iconnames as $iconname) {
			echo tag_icon('fa fa-'. $iconname). ' : ' . $iconname . PHP_EOL;
		}

		echo '--------------\n';
		$iconnames = explode(',', 'adjust,asterisk,ban-circle,bar-chart,barcode,beaker,beer,bell,bell-alt,bolt,book,bookmark,bookmark-empty,briefcase,bullhorn,calendar,camera,camera-retro,certificate,check,check-empty,circle,circle-blank,cloud,cloud-download,cloud-upload,coffee,cog,cogs,comment,comment-alt,comments,comments-alt,credit-card,dashboard,desktop,download,download-alt,edit,envelope,envelope-alt,exchange,exclamation-sign,external-link,eye-close,eye-open,facetime-video,fighter-jet,film,filter,fire,flag,folder-close,folder-open,folder-close-alt,folder-open-alt,food,gift,glass,globe,group,hdd,headphones,heart,heart-empty,home,inbox,info-sign,key,leaf,laptop,legal,lemon,lightbulb,lock,unlock,magic,magnet,map-marker,minus,minus-sign,mobile-phone,money,move,music,off,ok,ok-circle,ok-sign,pencil,picture,plane,plus,plus-sign,print,pushpin,qrcode,question-sign,quote-left,quote-right,random,refresh,remove,remove-circle,remove-sign,reorder,reply,resize-horizontal,resize-vertical,retweet,road,rss,screenshot,search,share,share-alt,shopping-cart,signal,signin,signout,sitemap,sort,sort-down,sort-up,spinner,star,star-empty,star-half,tablet,tag,tags,tasks,thumbs-down,thumbs-up,time,tint,trash,trophy,truck,umbrella,upload,upload-alt,user,user-md,volume-off,volume-down,volume-up,warning-sign,wrench,zoom-in,zoom-out,file,file-alt,cut,copy,paste,save,undo,repeat,text-height,text-width,align-left,align-center,align-right,align-justify,indent-left,indent-right,font,bold,italic,strikethrough,underline,link,paper-clip,columns,table,th-large,th,th-list,list,list-ol,list-ul,list-alt,angle-left,angle-right,angle-up,angle-down,arrow-down,arrow-left,arrow-right,arrow-up,caret-down,caret-left,caret-right,caret-up,chevron-down,chevron-left,chevron-right,chevron-up,circle-arrow-down,circle-arrow-left,circle-arrow-right,circle-arrow-up,double-angle-left,double-angle-right,double-angle-up,double-angle-down,hand-down,hand-left,hand-right,hand-up,circle,circle-blank,play-circle,play,pause,stop,step-backward,fast-backward,backward,forward,fast-forward,step-forward,eject,fullscreen,resize-full,resize-small,phone,phone-sign,facebook,facebook-sign,twitter,twitter-sign,github,github-alt,github-sign,linkedin,linkedin-sign,pinterest,pinterest-sign,google-plus,google-plus-sign,sign-blank,ambulance,beaker,h-sign,hospital,medkit,plus-sign-alt,stethoscope,user-md');
		foreach ($iconnames as $iconname) {
			echo tag_icon('fa fa-'. $iconname). ' : ' . $iconname . PHP_EOL;
		}
	}

}
