<!DOCTYPE html>
<html lang="en">
  @include("website.includes.head")
  <body>
  	@include("website.includes.nav")
    <!-- END nav -->
    
    @yield('content');

	@include("website.includes.footer")

		
        
  

  <!-- loader -->
  	@include("website.includes.loader")
    
  </body>
</html>