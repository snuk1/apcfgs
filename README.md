# APCFGs APP
### (Auto-Populate OPL CFGs files) by snuk

I've made a tool that can auto-fill/auto-populate the CFGs files for the PlayStation 2 (PS2) Homebrew App: [Open PS2 Loader (OPL)](http://www.ps2-home.com/forum/viewtopic.php?f=83&t=3) with the following attribute fields for OPL's INFO page:
(NOTE: these fields are supported by [OPL Manager](http://www.ps2-home.com/forum/viewtopic.php?f=13&t=189) .)

![APCFGs GUI](http://www.ps2-home.com/images/tutorials/APCFGs/how_ft0.png)

1. Title
2. Release Date
3. Rating (Rating and Rating Text)
4. Description
5. Developer
6. Genre

## How it works
The data is being supplied by [RAWG API](https://rawg.io/apidocs) , which is free and very flexible in comparison to other paid ones. And unfortunately all the game data that they provide comes only in English, so yeah, it will only populate the CFGs using English info (i.e. description, genre, title, etc.).

## Instructions
You just need to extract the [7zip file](https://www.7-zip.org/) , open the APCFGs folder, and then go to the `manuals` folder, there will be 2 manuals (one in English and other one in Brazilian Portuguese.  There is more info about it there on how it works, like the overwrite function (that will not only add the missing fields, but it will overwrite the mentioned fields above).  And also explains what is APCFGs, and how to use it!

## Open Source
Also it is open source, you can check out everything I did, it is in the `www` folder, it is made in `php`, so yeah as open source you guys can create your own versions of it/modify it, for me its OK as long as you mention the original project.

## Need Help?
If you got any questions, you can ask me in this [PS2-Home thread](http://www.ps2-home.com/forum/viewtopic.php?t=7964) , bye ;.  
