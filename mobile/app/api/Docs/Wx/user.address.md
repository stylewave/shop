##api/wx/user/address/list  用户地址列表

####链接
     http://10.10.10.145/dsc/mobile/public/api/wx/user/address/list


#### 参数
参数由  微信获取

####头部参数
1. x-ectouch-authorization     参数名
2.    参数值


####返回参数
1. code : 0 为正常   **1 为不正常**
2. data  : 数据 （数组）
    > 1. address_id: 1    //地址ID
    > 2. address_name: ""   //地址名称
    > 3. consignee: "名"    // 收货人名
    > 4. email: ""    // 邮箱
    > 5. mobile: "13562589645"    // 手机号
    > 6. address: "中国 北京 北京 东城区  qe"   // 具体地址
    > 7. country_name: "中国",     //国家名
    > 8. province_name: "北京"     //省名
    > 9. city_name: "北京"         //城市名
    > 10. district_name: "东城区"  // 区名
    > 11. street_name: ""       //街道名

