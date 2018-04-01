#coding:utf-8
import youtube_dl
import os

class MyLogger(object): #youtube_dl log
    def debug(self, msg):
        pass

    def warning(self, msg):
        pass

    def error(self, msg):
        print(msg)

def my_hook(d): #converting message
	if d['status'] == 'finished':
	    print('Done downloading, now converting ...')

def downloader(url): # download file config
	ydl_opts = {
	    'format': 'bestaudio/best',
	    'postprocessors': [{
	        'key': 'FFmpegExtractAudio',
	        'preferredcodec': 'mp3',
	        'preferredquality': '0',
	    }],
	    'logger': MyLogger(),
	    'progress_hooks': [my_hook],
	}
	with youtube_dl.YoutubeDL(ydl_opts) as ydl:
    			ydl.download([url])

def getMusic(url): #main function
	if (url.startswith("https://youtu.be/")):
		url = "https://www.youtube.com/watch?v=" + url.split("https://youtu.be/")[1]
		print (url)
	checkYtube = "https://www.youtube.com" # check youtube url
	if (url.startswith(checkYtube)): # check youtube url
		if "&" in url: 
			url = url.split("&")[0] 
		if not os.path.exists("mp3"):  #confirm the folder isn't exist 
		    os.makedirs("mp3") # build a folder to put .mp3 file
		os.chdir("mp3") # change dir (cd)
		downloader(url)
		os.chdir("../") # change dir (cd) pwd: {/}
	else:
		print("Not a youtube URL.")

if __name__ == '__main__':
	print("Please input a youtube URL:",end='')
	url = input()
	getMusic(url)
