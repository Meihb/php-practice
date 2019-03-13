
		var curDate = new Date();
		//结果日志
		var filename = "D:/weixin-readnum.log";
		var sw_num : System.IO.StreamWriter;
		if (System.IO.File.Exists(filename)){
			sw_num = System.IO.File.AppendText(filename);
		}
		else{
			sw_num = System.IO.File.CreateText(filename);
		}
		//debug日志
		var error_name = "D:/error.log";
		var sw_error : System.IO.StreamWriter;
		if (System.IO.File.Exists(error_name)){
			sw_error = System.IO.File.AppendText(error_name);
		}
		else{
			sw_error = System.IO.File.CreateText(error_name);
		}
		//查询主页 标题
		if (oSession.HostnameIs("mp.weixin.qq.com") && oSession.uriContains("https://mp.weixin.qq.com/mp/homepage")){

			oSession["ui-color"] = "green";
			var filename = "D:/weixin-pages.log";
			var curDate = new Date();
			var logContent =  "[" + curDate.toLocaleString() + "] " + oSession.PathAndQuery + "\r\n"+oSession.GetResponseBodyAsString()+"\r\n";
			var sw : System.IO.StreamWriter;
			if (System.IO.File.Exists(filename)){
				sw = System.IO.File.AppendText(filename);
				sw.Write(logContent);
			}
			else{
				sw = System.IO.File.CreateText(filename);
				sw.Write(logContent);
			}
			sw.Close();
			sw.Dispose();

		}else
			//查询 文章数据
			if (oSession.HostnameIs("mp.weixin.qq.com") && oSession.uriContains("https://mp.weixin.qq.com/mp/getappmsgext")){
			oSession["ui-color"] = "orange";
			var logContent =  "[" + curDate.toLocaleString() + "]" + oSession.PathAndQuery + "\r\n"+oSession.GetResponseBodyAsString()+"\r\n";
			sw_num.Write(logContent);


		}



		//修改主页面js
		if(oSession.fullUrl.Contains("https://mp.weixin.qq.com/s?__biz=")){//获取taskid,用来下一次跳转
			var fullUrl = oSession.fullUrl;
			sw_error.Write(fullUrl+"\r\n");
			var mid_start = fullUrl.IndexOf("&mid=")+5;
			var leftFullUrl = fullUrl.Substring(mid_start);
			var mid_end = leftFullUrl.IndexOf("&");
			var mid = oSession.fullUrl.Substring(mid_start,mid_end);
			sw_error.Write(mid_start+"\r\n"+mid_end+"\r\n"+"mid is "+mid+"\r\n");
			var responseJsonString  = oSession.GetResponseBodyAsString();//response字符串

			if(responseJsonString.IndexOf("该内容已被发布者删除")!=-1){//已被删除
				var responseJson = responseJsonString.replace("</script>",
					"</script><script language=\"javascript\" for=\"window\" event=\"onload\">setTimeout(function(){window.location=\"http:\//act1.dq.sdo.com\/dataAnalyzeTest\/test.html\";},5000);</script>"
					);
				oSession.utilSetResponseBody(responseJson);
				sw_num.Write( "[" + curDate.toLocaleString() + "]"+"mid:"+"")
			}else{


				oSession["ui-color"] = "red";
				var start = responseJsonString.IndexOf("nonce=\"")+7;
				var leftString = responseJsonString.Substring(start);
				var end = leftString.IndexOf("\"");
				var nonce = responseJsonString.Substring(start,end)

				sw_error.Write(start+"\r\n"+end+"\r\n"+nonce+"\r\n");
				var responseJson = responseJsonString.replace("</script>",
					"</script><script nonce =\""+nonce+"\" language=\"javascript\" for=\"window\" event=\"onload\">setTimeout(function(){window.location=\"http:\//act1.dq.sdo.com\/dataAnalyzeTest\/test.html\";},5000);</script>"
				);
				//sw_error.Write(responseJson+"\r\n");
				oSession.utilSetResponseBody(responseJson);
			}
		}
		sw_num.Close();
		sw_num.Dispose();

		sw_error.Close();
		sw_error.Dispose();

