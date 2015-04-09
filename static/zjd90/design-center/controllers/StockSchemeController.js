require(["PagerPlugin","DropdownPlugin"], function() {
	var stockSchemeCtr = avalon.define("StockSchemeController", function(vm){
		vm.items = [1,2,3,4,5,6,7];

        vm.pager = {
            currentPage: 1,
            perPages: 3,
            totalPages: 2,
            totalItems: 4,
            showJumper: false,
        }		
	})
	avalon.scan();
});
