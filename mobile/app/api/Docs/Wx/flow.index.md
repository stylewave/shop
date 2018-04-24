##api/wx/flow  小程序订单确认页面

####链接
     http://10.10.10.145/dsc/mobile/public/api/wx/flow

####参数

####头部参数
1. x-ectouch-authorization     参数名
2.    参数值


####返回参数
1. code : 0 为正常   **1 为不正常**
2. data  : 数据 （数组）
3. data 下 数据 goodsimg(数组)   商品图片
    > 1. "id": 858,    //分类ID
    > 2. "name": "家用电器",    //分类名称
    > 3. "cat_img": "/dsc/mobile/public/img/no_image.jpg",   //分类图片
    > 4. "haschild": 1,   //分类是否有子分类
    > 5. "cat_id"  : []  子分类 （数组）



##商品
    > 店铺名
    > 商品名
    > 商品图片
    > 商品价格  单价
    > 购物车数量
    > 商品配送方式
    > 买家留言
    > 店铺商品合计
## 支付方式
## 配送方式
    > 价格计算
    > 地区判断
## 发票信息
## 所有商品总价
## 是付款  商品费用 + 配送费用 + 支付费用



# 订单提交
1. 检查购物车商品
2. 检查库存
3. 用户登录
4. 收货人信息
5. 订单配送方式  商家地区
6. 检查积分 余额
7. 限购 金额
8. 判断实体商品   虚拟商品不用配送方式
9. 订单金额计算   ========
10.  红包  ---   包装  ---  贺卡
11.  如果使用余额  检查余额  是否足够  将 订单金额归零
12.  订单金额为0  修改状态为已确认、已付款
13.  插入订单表
14.  储值卡、余额、积分、红包、优惠券
15.  减少库存
16.  清空购物车
17.  清除缓存
18.  插入支付日志
19.  生成支付代码
20.  生成子订单
    > 获取所有商家ID
    > 获取订单商品
    > 商家与订单组合

ru_id[]:2
ru_name[]:绿联专卖店
shipping[]:16
shipping_dateStr[2]:
shipping_type[2]:0
postscript[]:

ru_id[]:0
ru_name[]:商创自营
shipping[]:16
shipping_dateStr[0]:
shipping_type[0]:0
postscript[]:

payment:11
need_inv:0
inv_type:0
inv_payee:个人
inv_content:不开发票
user_id:
store_id:0,0