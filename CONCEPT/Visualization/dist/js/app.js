(function(){"use strict";var e={9427:function(e,t,r){var a=r(9242),o=r(3494),s=r(7749),d=r(8429),l=r(8539),n=r(6265),c=r.n(n),i=r(3396),u=r(4870),g=r(65);const p=()=>c().get("productimp/v1/gatekeeper/authorized").then((e=>401!==e.data.status)).catch((e=>(console.debug(e),!0)));var m={namespaced:!0,state:{authorized:!1},getters:{isAuthorized:e=>e.authorized},mutations:{SET_AUTHORIZED(e,t){e.authorized=t}},actions:{async authorized({commit:e}){const t=await p();return new Promise(((r,a)=>{e("SET_AUTHORIZED",t),r(t)}))}}},b={namespaced:!0,state:{page:"products"},getters:{currentPage:e=>e.page},mutations:{SET_PAGE(e,t){e.page=t}},actions:{setPage({commit:e},t){e("SET_PAGE",t)}}};const f=()=>c().get("productimp/v1/datasources/list").then((e=>e.data.data)).catch((e=>{console.debug(e)})),h=e=>c().post("productimp/v1/datasources/read",{id:e}).then((e=>e.data.data)).catch((e=>{console.debug(e)})),y=e=>c().post("productimp/v1/datasources/create",e).then((e=>!0)),x=e=>c().post("productimp/v1/datasources/delete",{id:e}).then((e=>!0)),v=e=>c().post("productimp/v1/datasources/sync",{id:e}).then((e=>(console.log(e),!0)));var w={namespaced:!0,state:{dataSources:[]},getters:{allDataSources:e=>e.dataSources},mutations:{SET_DATASOURCES(e,t){e.dataSources=t}},actions:{async fetchAll({commit:e}){const t=await f();return new Promise(((r,a)=>{e("SET_DATASOURCES",t),r(t)}))},async fetchSingle({commit:e},t){const r=await h(t);return new Promise(((t,a)=>{e("SET_DATASOURCE",r),t(r)}))},async create({commit:e},t){return new Promise(((r,a)=>{const o=y(t);o||a(o);const s=f();e("SET_DATASOURCES",s),r(o)}))},async delete({commit:e},t){return new Promise(((e,r)=>{const a=x(t);a||r(a),e(a)}))}}};const k=()=>c().get("productimp/v1/woocommerce/product/list").then((e=>e.data.data)).catch((e=>{console.debug(e)})),_=e=>c().post("productimp/v1/woocommerce/product/create",{product_id:e}).then((e=>(console.log(e),!0))),C=()=>c().get("productimp/v1/products/list").then((e=>e.data.data)).catch((e=>(console.debug(e),!0))),S=(e,t)=>c().post("productimp/v1/products/map",{product_id:e,map:t}).then((e=>(console.log(e),!0))),P=()=>c().get("productimp/v1/products/map").then((e=>e.data.data)).catch((e=>(console.debug(e),!0)));var D={namespaced:!0,state:{products:[],mappings:[],woocommerceProducts:[]},getters:{allProducts:e=>e.products.map((e=>({id:e.id,source:e.datasource_id,product:JSON.parse(e.product)}))),allMappings:e=>e.mappings,allWoocommerce:e=>e.woocommerceProducts},mutations:{SET_PRODUCTS(e,t){e.products=t},SET_MAPPINGS(e,t){e.mappings=t},SET_WOOCOMMERCE(e,t){e.woocommerceProducts=t}},actions:{async fetchAll({commit:e}){const t=await C();return new Promise(((r,a)=>{e("SET_PRODUCTS",t),r(t)}))},async fetchAllWooCommerce({commit:e}){const t=await k();return new Promise(((r,a)=>{e("SET_WOOCOMMERCE",t),r(t)}))},async getMappings({commit:e}){const t=await P();return new Promise(((r,a)=>{e("SET_MAPPINGS",t),r(t)}))}}},M=new g.ZP.Store({modules:{authorization:m,navigation:b,datasources:w,products:D}}),A=r(7139);const j={class:"bg-gray-800 fixed z-40 w-full"},U={class:"max-w-7xl mx-auto px-2 sm:px-6 lg:px-8"},E={class:"relative flex items-center justify-between h-16"},O=(0,i.uE)('<div class="absolute inset-y-0 left-0 flex items-center sm:hidden"><button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false"><span class="sr-only">Open main menu</span><svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg><svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg></button></div>',1),z=(0,i._)("div",{class:"flex-shrink-0 flex items-center"},[(0,i._)("h2",{class:"font-bold text-white"},"ProductImp")],-1),T={class:"hidden sm:block sm:ml-6"},H={key:0,class:"flex space-x-4"},W={key:1},R=(0,i._)("div",{class:"absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"},null,-1),B=(0,i._)("div",{class:"sm:hidden",id:"mobile-menu"},[(0,i._)("div",{class:"px-2 pt-2 pb-3 space-y-1"},[(0,i._)("a",{href:"#",class:"bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium","aria-current":"page"},"Products"),(0,i._)("a",{href:"#",class:"text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"},"Datasources")])],-1);var q=(0,i.aZ)({__name:"NavigationBar",setup(e){const t=(0,i.Fl)((()=>M.getters["navigation/currentPage"])),r=(0,i.Fl)((()=>M.getters["authorization/isAuthorized"])),a="s";return(e,o)=>((0,i.wg)(),(0,i.iD)("nav",j,[(0,i._)("div",U,[(0,i._)("div",E,[O,(0,i._)("div",{class:(0,A.C_)(["flex-1 flex items-center justify-center sm:items-stretch",{"sm:place-content-between":!(0,u.SU)(r),"sm:justify-start":(0,u.SU)(r)}])},[z,(0,i._)("div",T,[(0,u.SU)(r)?((0,i.wg)(),(0,i.iD)("div",H,[(0,i._)("button",{onClick:o[0]||(o[0]=e=>(0,u.SU)(M).dispatch("navigation/setPage","products")),class:(0,A.C_)([["products"===(0,u.SU)(t)?["bg-gray-900","text-white"]:["hover:bg-gray-700","hover:text-white"]],"text-gray-300 px-3 py-2 rounded-md text-sm font-medium"]),"aria-current":"page"}," Products ",2),(0,i._)("button",{onClick:o[1]||(o[1]=e=>(0,u.SU)(M).dispatch("navigation/setPage","datasources")),class:(0,A.C_)([["datasources"===(0,u.SU)(t)?["bg-gray-900","text-white"]:["hover:bg-gray-700","hover:text-white"]],"text-gray-300 px-3 py-2 rounded-md text-sm font-medium"])}," Datasources ",2)])):((0,i.wg)(),(0,i.iD)("div",W,[(0,i._)("a",{href:a,class:"px-4 py-2 outline-none border-2 border-red-400 rounded text-red-500 font-medium active:scale-95 hover:bg-red-600 hover:text-white hover:border-transparent focus:bg-red-600 focus:text-white focus:border-transparent focus:ring-2 focus:ring-red-600 focus:ring-offset-2 disabled:bg-gray-400/80 disabled:shadow-none disabled:cursor-not-allowed transition-colors duration-200"}," Authorize ")]))])],2),R])]),B]))}});const I=q;var F=I,Z=r(2492),N=r.n(Z);const Y={class:"mx-auto p-4 w-full max-w-2xl h-full md:h-auto"},$={class:"relative bg-white rounded-lg shadow dark:bg-gray-700"},V={class:"flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600"},G=(0,i._)("h3",{class:"text-xl font-semibold text-gray-900 dark:text-white"}," Product Information ",-1),L=(0,i.Uk)(" x "),K=(0,i._)("span",{class:"sr-only"},"Close modal",-1),J=[L,K],X={class:"p-1 space-y-6 h-96",style:{"overflow-y":"auto"}},Q={class:"text-sm text-left text-gray-500 dark:text-gray-400"},ee={class:"px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap",style:{width:"1%"}},te={class:"px-6 py-4"},re={class:"flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600"};var ae=(0,i.aZ)({__name:"ProductInfoModal",props:{visible:Boolean,currentProduct:String},emits:["closeProductInfoModal"],setup(e,{emit:t}){(0,u.iH)(!1),(0,u.iH)(!1);return(t,r)=>((0,i.wg)(),(0,i.iD)("div",{id:"sync-data-modal",tabindex:"-1","aria-hidden":"true",class:(0,A.C_)([{hidden:!e.visible},"bgblackopacitied fixed z-50 top-0 pt-20 w-full h-full"])},[(0,i._)("div",Y,[(0,i._)("div",$,[(0,i._)("div",V,[G,(0,i._)("button",{type:"button",onClick:r[0]||(r[0]=e=>t.$emit("closeProductInfoModal")),class:"text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white","data-modal-toggle":"syncDataSourceModal"},J)]),(0,i._)("div",X,[(0,i._)("table",Q,[(0,i._)("tbody",null,[((0,i.wg)(!0),(0,i.iD)(i.HY,null,(0,i.Ko)(e.currentProduct,((e,t)=>((0,i.wg)(),(0,i.iD)("tr",{key:t,class:"bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"},[(0,i._)("td",ee,(0,A.zw)(t),1),(0,i._)("td",te,(0,A.zw)(e),1)])))),128))])])]),(0,i._)("div",re,[(0,i._)("button",{"data-modal-toggle":"defaultModal",onClick:r[1]||(r[1]=e=>t.$emit("closeProductInfoModal")),type:"button",class:"text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"}," Close ")])])])],2))}});const oe=ae;var se=oe,de=r(3029);const le={class:"mapping-row bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"},ne={class:"px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"},ce=["disabled"],ie={class:"px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"},ue={class:"px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"},ge=["disabled"],pe={class:"px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"},me={class:"-mx-2"};var be=(0,i.aZ)({__name:"MappingRow",props:{mappingData:Object},emits:["mappingRowSaved","mappingRowRemoved","editMode"],setup(e,{emit:t}){const r=e,o=(0,u.iH)(!1),s=(0,u.iH)({...r.mappingData}),d=()=>{t("mappingRowRemoved",s),t("editMode",!1)},l=()=>{t("editMode",!0),o.value=!0},n=()=>{t("mappingRowSaved",s),o.value=!1,t("editMode",!1)};return(e,t)=>{const r=(0,i.up)("font-awesome-icon");return(0,i.wg)(),(0,i.iD)("tr",le,[(0,i._)("td",ne,[(0,i.wy)((0,i._)("input",{disabled:!o.value,class:(0,A.C_)([{"cursor-no-drop":!o.value},"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"]),type:"text","onUpdate:modelValue":t[0]||(t[0]=e=>s.value.product_field_id=e),id:"product_field_id",placeholder:"Product Field",required:""},null,10,ce),[[a.nr,s.value.product_field_id]])]),(0,i._)("td",ie,[(0,i.Wm)(r,{icon:"fa-solid fa-arrow-right-long"})]),(0,i._)("td",ue,[(0,i.wy)((0,i._)("input",{disabled:!o.value,class:(0,A.C_)([{"cursor-no-drop":!o.value},"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"]),type:"text",id:"woocommerce_field_id","onUpdate:modelValue":t[1]||(t[1]=e=>s.value.woocommerce_field_id=e),placeholder:"Woocommerce Field",required:""},null,10,ge),[[a.nr,s.value.woocommerce_field_id]])]),(0,i._)("td",pe,[(0,i._)("div",me,[o.value?((0,i.wg)(),(0,i.iD)("button",{key:0,onClick:t[2]||(t[2]=e=>n()),class:"mx-2"},[(0,i.Wm)(r,{icon:"fa-solid fa-floppy-disk"})])):(0,i.kq)("",!0),o.value?(0,i.kq)("",!0):((0,i.wg)(),(0,i.iD)("button",{key:1,onClick:t[3]||(t[3]=e=>l()),class:"mx-2"},[(0,i.Wm)(r,{icon:"fa-solid fa-pen-to-square"})])),(0,i._)("button",{onClick:t[4]||(t[4]=e=>d()),class:"mx-2"},[(0,i.Wm)(r,{icon:"fa-solid fa-times"})])])])])}}});const fe=be;var he=fe;const ye={class:"mx-auto p-4 w-full max-w-2xl h-full md:h-auto"},xe={class:"relative bg-white rounded-lg shadow dark:bg-gray-700"},ve={class:"flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600"},we={class:"flex justify-between w-full"},ke=(0,i._)("h3",{class:"text-xl font-semibold text-gray-900 dark:text-white"},"Map Product",-1),_e=(0,i.Uk)(" Add Mapping "),Ce={class:"p-1 space-y-6 h-96",style:{"overflow-y":"auto"}},Se={class:"text-sm text-left text-gray-500 dark:text-gray-400 w-full"},Pe={key:0},De=(0,i._)("td",{class:"px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"}," No Mappings configured yet. ",-1),Me=[De],Ae={class:"flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600"},je=["disabled"];var Ue=(0,i.aZ)({__name:"ProductMap",props:{visible:Boolean,currentProduct:Object},emits:["closeProductMapModal"],setup(e,{emit:t}){const r=e,a=(0,u.iH)(r.currentProduct.map??[]),o=(0,u.iH)(!1),s=e=>{o.value=e},d=e=>{const t=a.value.findIndex((t=>t.id===e.value.id));a.value[t]=e.value},l=e=>{const t=a.value.findIndex((t=>t.id===e.value.id));t>-1&&a.value.splice(t,1)},n=()=>{a.value.push({id:(0,de.Z)()})},c=()=>{S(r.currentProduct.id,a.value),t("closeProductMapModal")};return(t,r)=>{const u=(0,i.up)("font-awesome-icon");return(0,i.wg)(),(0,i.iD)("div",{id:"sync-data-modal",tabindex:"-1","aria-hidden":"true",class:(0,A.C_)([{hidden:!e.visible},"bgblackopacitied fixed z-50 top-0 pt-20 w-full h-full"])},[(0,i._)("div",ye,[(0,i._)("div",xe,[(0,i._)("div",ve,[(0,i._)("div",we,[ke,(0,i._)("button",{onClick:r[0]||(r[0]=e=>n()),class:"px-4 py-2 outline-none border-2 border-blue-400 rounded text-blue-500 font-medium active:scale-95 hover:bg-blue-600 hover:text-white hover:border-transparent focus:bg-blue-600 focus:text-white focus:border-transparent focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 disabled:bg-gray-400/80 disabled:shadow-none disabled:cursor-not-allowed transition-colors duration-200"},[(0,i.Wm)(u,{icon:"fa-solid fa-plus"}),_e])])]),(0,i._)("div",Ce,[(0,i._)("table",Se,[(0,i._)("tbody",null,[((0,i.wg)(!0),(0,i.iD)(i.HY,null,(0,i.Ko)(a.value,(e=>((0,i.wg)(),(0,i.j4)(he,{key:e.id,"mapping-data":e,onMappingRowSaved:d,onMappingRowRemoved:l,onEditMode:s},null,8,["mapping-data"])))),128)),a.value.length?(0,i.kq)("",!0):((0,i.wg)(),(0,i.iD)("tr",Pe,Me))])])]),(0,i._)("div",Ae,[(0,i._)("button",{onClick:c,disabled:o.value,type:"button",class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"}," Save ",8,je),(0,i._)("button",{"data-modal-toggle":"defaultModal",onClick:r[1]||(r[1]=e=>t.$emit("closeProductMapModal")),type:"button",class:"text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"}," Cancel ")])])])],2)}}});const Ee=Ue;var Oe=Ee;const ze={class:"container mx-auto px-5 pt-10"},Te=(0,i._)("div",{class:"mb-5 flex justify-between"},[(0,i._)("h2",{class:"text-2xl font-light"},"Products")],-1),He={class:"relative overflow-x-auto shadow-md sm:rounded-lg"},We={class:"w-full text-sm text-left text-gray-500 dark:text-gray-400"},Re=(0,i._)("thead",{class:"text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"},[(0,i._)("tr",null,[(0,i._)("th",{scope:"col",class:"px-6 py-3"}),(0,i._)("th",{scope:"col",class:"px-6 py-3"},"Source"),(0,i._)("th",{scope:"col",class:"px-6 py-3"},"Name"),(0,i._)("th",{scope:"col",class:"px-6 py-3"},"Synced"),(0,i._)("th",{scope:"col",class:"px-6 py-3"},"Mapped"),(0,i._)("th",{scope:"col",class:"px-6 py-3"},"Actions")])],-1),Be={key:0},qe={class:"px-6 py-4 text-gray-900 dark:text-white",style:{width:"1%"}},Ie=["onClick"],Fe={scope:"row",class:"px-6 py-4 font-light text-gray-900 dark:text-white whitespace-nowrap"},Ze={scope:"row",class:"px-6 py-4 font-light text-gray-900 dark:text-white whitespace-nowrap"},Ne={scope:"row",class:"px-6 py-4 font-light text-gray-900 dark:text-white whitespace-nowrap"},Ye={scope:"row",class:"px-6 py-4 font-light text-gray-900 dark:text-white whitespace-nowrap"},$e={class:"px-6 py-4 flex"},Ve=["onClick"],Ge=["onClick","disabled"],Le={key:0,class:"container w-full bg-gray-50 p-4"},Ke=(0,i._)("img",{src:"https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif",alt:"spinner",class:"h-8 m-auto d-block"},null,-1),Je=[Ke];var Xe=(0,i.aZ)({__name:"ProductsPage",setup(e){const t=(0,u.iH)(!0),r=(0,u.iH)(),a=(0,u.iH)(!1),o=(0,u.iH)(!1),s=(0,i.Fl)((()=>M.getters["products/allProducts"])),d=(0,i.Fl)((()=>M.getters["products/allMappings"])),l=(0,i.Fl)((()=>M.getters["products/allWoocommerce"])),n=(0,u.iH)([]),c=e=>{if(!d.value)return{...e,map:[]};const t=d.value.find((t=>t.product_id===e.id));return t?{...e,map:JSON.parse(t.map)}:{...e,map:[]}},g=()=>{const e=[M.dispatch("products/fetchAll"),M.dispatch("products/getMappings"),M.dispatch("products/fetchAllWooCommerce")];Promise.all(e).then((e=>{n.value=s.value.map((e=>{const t=c(e);if(!l.value)return t;const r=l.value.find((t=>t.product_id===e.id));return r?{...t,synced:r}:t})),Promise.resolve(),t.value=!1}))},p=((0,u.iH)(!1),(e=null)=>{r.value=e,a.value=!a.value}),m=(e=null)=>{r.value=e,o.value=!o.value},b=e=>{N().fire({title:"Synchronize product with WooCommerce",text:"This will add the selected product to WooCommerce Product List.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Sync"}).then((t=>{console.log(t),t.isConfirmed&&(_(e),N().fire({icon:"success",title:`Succesfully synced product: ${e}`,toast:!0,position:"top-end",showConfirmButton:!1,timer:5e3,timerProgressBar:!0}))}))};return(0,i.bv)((()=>{g()})),(e,s)=>{const d=(0,i.up)("font-awesome-icon");return(0,i.wg)(),(0,i.iD)(i.HY,null,[r.value?((0,i.wg)(),(0,i.j4)(se,{key:0,"current-product":r.value,visible:a.value,onCloseProductInfoModal:s[0]||(s[0]=e=>p())},null,8,["current-product","visible"])):(0,i.kq)("",!0),r.value?((0,i.wg)(),(0,i.j4)(Oe,{key:1,"current-product":r.value,visible:o.value,onCloseProductMapModal:s[1]||(s[1]=e=>m())},null,8,["current-product","visible"])):(0,i.kq)("",!0),(0,i._)("div",ze,[Te,(0,i._)("div",He,[(0,i._)("table",We,[Re,t.value?(0,i.kq)("",!0):((0,i.wg)(),(0,i.iD)("tbody",Be,[((0,i.wg)(!0),(0,i.iD)(i.HY,null,(0,i.Ko)(n.value,(e=>((0,i.wg)(),(0,i.iD)("tr",{key:e.id,class:"bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"},[(0,i._)("td",qe,[(0,i._)("button",{onClick:t=>p(e.product)},[(0,i.Wm)(d,{icon:"fa-regular fa-circle-question"})],8,Ie)]),(0,i._)("td",Fe,(0,A.zw)(e.source),1),(0,i._)("td",Ze,(0,A.zw)(e.product.name),1),(0,i._)("td",Ne,[e.synced?(0,i.kq)("",!0):((0,i.wg)(),(0,i.j4)(d,{key:0,class:"text-red-500",icon:"fa-regular fa-circle-xmark"})),e.synced?((0,i.wg)(),(0,i.j4)(d,{key:1,class:"text-green-500",icon:"fa-regular fa-circle-check"})):(0,i.kq)("",!0)]),(0,i._)("td",Ye,[e.map.length?(0,i.kq)("",!0):((0,i.wg)(),(0,i.j4)(d,{key:0,class:"text-red-500",icon:"fa-regular fa-circle-xmark"})),e.map.length?((0,i.wg)(),(0,i.j4)(d,{key:1,class:"text-green-500",icon:"fa-regular fa-circle-check"})):(0,i.kq)("",!0)]),(0,i._)("td",$e,[(0,i._)("button",{onClick:t=>m({...e.product,id:e.id,map:e.map}),class:"font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2",title:"Configure Product with WooCommerce"},[(0,i.Wm)(d,{icon:"fa-solid fa-sliders"})],8,Ve),(0,i._)("button",{onClick:t=>b(e.id),disabled:e.synced,class:"font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2",title:"Sync to WooCommerce"},[(0,i.Wm)(d,{icon:"fa-solid fa-shop"})],8,Ge)])])))),128))]))]),t.value?((0,i.wg)(),(0,i.iD)("div",Le,Je)):(0,i.kq)("",!0)])])],64)}}});const Qe=Xe;var et=Qe;const tt={class:"mx-auto p-4 w-full max-w-2xl h-full md:h-auto"},rt={class:"relative bg-white rounded-lg shadow dark:bg-gray-700"},at={class:"flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600"},ot=(0,i._)("h3",{class:"text-xl font-semibold text-gray-900 dark:text-white"}," Add Data Source ",-1),st=(0,i.Uk)(" x "),dt=(0,i._)("span",{class:"sr-only"},"Close modal",-1),lt=[st,dt],nt={class:"p-6 space-y-6"},ct={class:"mb-6"},it=(0,i._)("label",{for:"datasource_name",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"},"Name ",-1),ut={class:"mb-6"},gt=(0,i._)("label",{for:"datasource_url",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"},"URL",-1),pt={class:"flex justify-between"},mt={class:"mb-6"},bt=(0,i._)("label",{for:"datasource_username",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"},"Username",-1),ft={class:"mb-6"},ht=(0,i._)("label",{for:"datasource_password",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"},"Password",-1),yt={class:"flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600"};var xt=(0,i.aZ)({__name:"AddDataSourceModal",props:{visible:Boolean},emits:["closeAddDataSourceModal","refetchDataSources"],setup(e,{emit:t}){(0,u.iH)(!1);const r=(0,u.iH)({datasource_name:null,datasource_url:null,datasource_credentials:{username:null,password:null}}),o=()=>{M.dispatch("datasources/create",r.value),r.value={datasource_name:null,datasource_url:null,datasource_credentials:{username:null,password:null}},t("refetchDataSources"),t("closeAddDataSourceModal")};return(t,s)=>((0,i.wg)(),(0,i.iD)("div",{id:"defaultModal",tabindex:"-1","aria-hidden":"true",class:(0,A.C_)([{hidden:!e.visible},"bgblackopacitied fixed z-50 top-0 pt-20 w-full h-full"])},[(0,i._)("div",tt,[(0,i._)("div",rt,[(0,i._)("div",at,[ot,(0,i._)("button",{type:"button",onClick:s[0]||(s[0]=e=>t.$emit("closeAddDataSourceModal")),class:"text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white","data-modal-toggle":"defaultModal"},lt)]),(0,i._)("div",nt,[(0,i._)("form",null,[(0,i._)("div",ct,[it,(0,i.wy)((0,i._)("input",{type:"text",id:"datasource_name","onUpdate:modelValue":s[1]||(s[1]=e=>r.value.datasource_name=e),class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",placeholder:"De Eekhoorn",required:""},null,512),[[a.nr,r.value.datasource_name]])]),(0,i._)("div",ut,[gt,(0,i.wy)((0,i._)("input",{type:"text",id:"datasource_url",class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",placeholder:"https://www.google.nl/","onUpdate:modelValue":s[2]||(s[2]=e=>r.value.datasource_url=e),required:""},null,512),[[a.nr,r.value.datasource_url]])]),(0,i._)("div",pt,[(0,i._)("div",mt,[bt,(0,i.wy)((0,i._)("input",{type:"text",id:"datasource_username",class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-max p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500","onUpdate:modelValue":s[3]||(s[3]=e=>r.value.datasource_credentials.username=e),placeholder:"johndoe@gmail.com",required:""},null,512),[[a.nr,r.value.datasource_credentials.username]])]),(0,i._)("div",ft,[ht,(0,i.wy)((0,i._)("input",{type:"password",id:"datasource_password","onUpdate:modelValue":s[4]||(s[4]=e=>r.value.datasource_credentials.password=e),class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-max p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",required:""},null,512),[[a.nr,r.value.datasource_credentials.password]])])])])]),(0,i._)("div",yt,[(0,i._)("button",{"data-modal-toggle":"defaultModal",type:"button",onClick:s[5]||(s[5]=e=>o()),class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"}," Save "),(0,i._)("button",{"data-modal-toggle":"defaultModal",onClick:s[6]||(s[6]=e=>t.$emit("closeAddDataSourceModal")),type:"button",class:"text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"}," Cancel ")])])])],2))}});const vt=xt;var wt=vt;const kt=e=>((0,i.dD)("data-v-428dea04"),e=e(),(0,i.Cn)(),e),_t={class:"container mx-auto px-5 pt-10"},Ct={class:"mb-5 flex justify-between"},St=kt((()=>(0,i._)("h2",{class:"text-2xl font-light"},"Data Sources",-1))),Pt=(0,i.Uk)(" Add "),Dt={class:"relative overflow-x-auto shadow-md sm:rounded-lg"},Mt={class:"w-full text-sm text-left text-gray-500 dark:text-gray-400"},At=kt((()=>(0,i._)("thead",{class:"text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"},[(0,i._)("tr",null,[(0,i._)("th",{scope:"col",class:"px-6 py-3"},"Name"),(0,i._)("th",{scope:"col",class:"px-6 py-3"},"URL"),(0,i._)("th",{scope:"col",class:"px-6 py-3"},"Actions")])],-1))),jt={key:0},Ut={scope:"row",class:"px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"},Et={class:"px-6 py-4"},Ot={class:"px-6 py-4 flex"},zt=["onClick"],Tt=["onClick"];var Ht=(0,i.aZ)({__name:"DataSourcesPage",setup(e){const t=(0,u.iH)(!0),r=(0,i.Fl)((()=>M.getters["datasources/allDataSources"])),a=()=>{const e=[M.dispatch("datasources/fetchAll")];Promise.all(e).then((e=>{t.value=!1,Promise.resolve()}))},o=((0,u.iH)(),(0,u.iH)(!1)),s=()=>{o.value=!o.value},d=e=>{N().fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!"}).then((t=>{t.isConfirmed&&Promise.all([M.dispatch("datasources/delete",e)]).catch((e=>{N().fire("Error!","Something went wrong deleting the record","error")})).then((e=>{e&&(N().fire("Deleted!","Your file has been deleted.","success"),a())}))}))},l=e=>{console.log(e),N().fire({title:"Synchronize Data Source",text:"This will import all the products from the selected datasource and will take around 10 minutes to complete",footer:"<strong>Please dont close the page while syncing the data source</strong>",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Sync"}).then((t=>{console.log(t),t.isConfirmed&&(v(e),N().fire({icon:"success",title:`Syncing Data Source: ${e}`,toast:!0,position:"top-end",showConfirmButton:!1,timer:6e5,timerProgressBar:!0}))}))};return(0,i.bv)((()=>{a()})),(e,n)=>{const c=(0,i.up)("font-awesome-icon");return(0,i.wg)(),(0,i.iD)(i.HY,null,[(0,i._)("div",_t,[(0,i._)("div",Ct,[St,(0,i._)("button",{"data-modal-toggle":"defaultModal",onClick:n[0]||(n[0]=e=>s()),class:"px-4 py-2 outline-none border-2 border-blue-400 rounded text-blue-500 font-medium active:scale-95 hover:bg-blue-600 hover:text-white hover:border-transparent focus:bg-blue-600 focus:text-white focus:border-transparent focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 disabled:bg-gray-400/80 disabled:shadow-none disabled:cursor-not-allowed transition-colors duration-200"},[(0,i.Wm)(c,{icon:"fa-solid fa-plus"}),Pt])]),(0,i._)("div",Dt,[(0,i._)("table",Mt,[At,t.value?(0,i.kq)("",!0):((0,i.wg)(),(0,i.iD)("tbody",jt,[((0,i.wg)(!0),(0,i.iD)(i.HY,null,(0,i.Ko)((0,u.SU)(r),(e=>((0,i.wg)(),(0,i.iD)("tr",{key:e.datasource_name,class:"bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"},[(0,i._)("th",Ut,(0,A.zw)(e.datasource_name),1),(0,i._)("td",Et,(0,A.zw)(e.datasource_url),1),(0,i._)("td",Ot,[(0,i._)("button",{onClick:t=>l(e.id),class:"font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2"},[(0,i.Wm)(c,{icon:"fa-solid fa-rotate"})],8,zt),(0,i._)("button",{onClick:t=>d(e.id),class:"font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2"},[(0,i.Wm)(c,{icon:"fa-solid fa-trash"})],8,Tt)])])))),128))]))])])]),(0,i.Wm)(wt,{visible:o.value,onCloseAddDataSourceModal:n[1]||(n[1]=e=>s()),onRefetchDataSources:n[2]||(n[2]=e=>a())},null,8,["visible"])],64)}}}),Wt=r(89);const Rt=(0,Wt.Z)(Ht,[["__scopeId","data-v-428dea04"]]);var Bt=Rt;const qt={class:"pt-12"};var It=(0,i.aZ)({__name:"PageSelect",setup(e){const t=(0,i.Fl)((()=>M.getters["navigation/currentPage"]));return(e,r)=>((0,i.wg)(),(0,i.iD)("div",qt,["products"===(0,u.SU)(t)?((0,i.wg)(),(0,i.j4)(et,{key:0})):(0,i.kq)("",!0),"datasources"===(0,u.SU)(t)?((0,i.wg)(),(0,i.j4)(Bt,{key:1,class:"mt-20"})):(0,i.kq)("",!0)]))}});const Ft=It;var Zt=Ft;const Nt={key:1,class:"p-5"},Yt=(0,i._)("h2",{class:"font-bold"}," User is unauthorized, Please use the authentication button to continue. ",-1),$t=[Yt];var Vt=(0,i.aZ)({__name:"App",setup(e){const t=(0,u.iH)(!0),r=(0,i.Fl)((()=>M.getters["authorization/isAuthorized"]));return(0,i.bv)((()=>{const e=[M.dispatch("authorization/authorized")];Promise.all(e).then((()=>{t.value=!1,Promise.resolve()}))})),(e,o)=>(0,i.wy)(((0,i.wg)(),(0,i.iD)("div",null,[(0,i.Wm)(F),(0,u.SU)(r)?((0,i.wg)(),(0,i.j4)(Zt,{key:0})):((0,i.wg)(),(0,i.iD)("div",Nt,$t))],512)),[[a.F8,!t.value]])}});const Gt=Vt;var Lt=Gt;c().defaults.headers.common["X-WP-Nonce"]=window.ProductImp.nonce,c().defaults.baseURL="https://boersma.dev/wp-json/",o.vI.add(d.FDd,l.go9,l.$aW,l.Yai,l.r8p,l.cRF,l.jmi,l.NBC,l.EdJ,d.f8k,d.$9F,l.YyO),(0,a.ri)(Lt).use(M).component("font-awesome-icon",s.GN).mount("#app")}},t={};function r(a){var o=t[a];if(void 0!==o)return o.exports;var s=t[a]={exports:{}};return e[a].call(s.exports,s,s.exports,r),s.exports}r.m=e,function(){var e=[];r.O=function(t,a,o,s){if(!a){var d=1/0;for(i=0;i<e.length;i++){a=e[i][0],o=e[i][1],s=e[i][2];for(var l=!0,n=0;n<a.length;n++)(!1&s||d>=s)&&Object.keys(r.O).every((function(e){return r.O[e](a[n])}))?a.splice(n--,1):(l=!1,s<d&&(d=s));if(l){e.splice(i--,1);var c=o();void 0!==c&&(t=c)}}return t}s=s||0;for(var i=e.length;i>0&&e[i-1][2]>s;i--)e[i]=e[i-1];e[i]=[a,o,s]}}(),function(){r.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return r.d(t,{a:t}),t}}(),function(){r.d=function(e,t){for(var a in t)r.o(t,a)&&!r.o(e,a)&&Object.defineProperty(e,a,{enumerable:!0,get:t[a]})}}(),function(){r.g=function(){if("object"===typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"===typeof window)return window}}()}(),function(){r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)}}(),function(){var e={143:0};r.O.j=function(t){return 0===e[t]};var t=function(t,a){var o,s,d=a[0],l=a[1],n=a[2],c=0;if(d.some((function(t){return 0!==e[t]}))){for(o in l)r.o(l,o)&&(r.m[o]=l[o]);if(n)var i=n(r)}for(t&&t(a);c<d.length;c++)s=d[c],r.o(e,s)&&e[s]&&e[s][0](),e[s]=0;return r.O(i)},a=self["webpackChunkproductimp"]=self["webpackChunkproductimp"]||[];a.forEach(t.bind(null,0)),a.push=t.bind(null,a.push.bind(a))}();var a=r.O(void 0,[998],(function(){return r(9427)}));a=r.O(a)})();
//# sourceMappingURL=app.js.map