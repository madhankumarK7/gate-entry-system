import{_ as c}from"./AppLayout-CrsxaWs3.js";import p from"./DeleteUserForm-lyCYg_gD.js";import l from"./LogoutOtherBrowserSessionsForm-CP-zo0sN.js";import{S as s}from"./SectionBorder-Dwsz56Y3.js";import f from"./TwoFactorAuthenticationForm-DThSEAYi.js";import u from"./UpdatePasswordForm-Ci38GwOF.js";import _ from"./UpdateProfileInformationForm-CROuAsR7.js";import{o,c as d,w as n,a as i,e as r,b as t,f as a,F as h}from"./app-VAnXGvZi.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./DialogModal-C7yIBZiL.js";import"./SectionTitle-8_Kpdr3n.js";import"./DangerButton-CWmZl5yb.js";import"./TextInput-kuGajvQa.js";import"./SecondaryButton-UqsU15g-.js";import"./ActionMessage-Bka8Lulf.js";import"./PrimaryButton-faRzyedr.js";import"./InputLabel-CH4YKuOL.js";import"./FormSection-QzmReaTl.js";const g=i("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Profile ",-1),$={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},w={key:0},k={key:1},y={key:2},z={__name:"Show",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array},setup(m){return(e,x)=>(o(),d(c,{title:"Profile"},{header:n(()=>[g]),default:n(()=>[i("div",null,[i("div",$,[e.$page.props.jetstream.canUpdateProfileInformation?(o(),r("div",w,[t(_,{user:e.$page.props.auth.user},null,8,["user"]),t(s)])):a("",!0),e.$page.props.jetstream.canUpdatePassword?(o(),r("div",k,[t(u,{class:"mt-10 sm:mt-0"}),t(s)])):a("",!0),e.$page.props.jetstream.canManageTwoFactorAuthentication?(o(),r("div",y,[t(f,{"requires-confirmation":m.confirmsTwoFactorAuthentication,class:"mt-10 sm:mt-0"},null,8,["requires-confirmation"]),t(s)])):a("",!0),t(l,{sessions:m.sessions,class:"mt-10 sm:mt-0"},null,8,["sessions"]),e.$page.props.jetstream.hasAccountDeletionFeatures?(o(),r(h,{key:3},[t(s),t(p,{class:"mt-10 sm:mt-0"})],64)):a("",!0)])])]),_:1}))}};export{z as default};
