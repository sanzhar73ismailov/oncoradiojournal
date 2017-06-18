rem файл для архивирования папки сайта в файл архива в папку Дропбокса
rem должен находиться в корне сайта
echo ----------- START BACKUP -------------
echo off
rem 1) укзазываем папку, где находится WinRAR
set winrarDir=C:\Program Files\WinRAR
rem 2) укзазываем папку, где будет сохраняться архив
set dirtosave=C:\Users\sanzhar.ismailov\Dropbox\Sanzhar\php\PUBL\ПодЖурнал
rem 3) укзазываем папку с файлом не архивируемых файлов
set ignore_list="%dirtosave%\ignore_list.txt"

rem forming archive file name
set YYYY=%DATE:~6,4%
rem echo year=%YYYY%
set MN=%DATE:~3,2%
rem echo month=%MN%
set DD=%DATE:~0,2%
rem echo day=%DD%
set HH=%TIME:~0,2%
set MM=%TIME:~3,2%
set SS=%TIME:~6,2%

set arcfile="%dirtosave%\publ_%YYYY%%MN%%DD%_%HH%%MM%%SS%_%COMPUTERNAME%.rar"

"%winrarDir%\WinRAR.exe" a -r -x@%ignore_list% %arcfile%

pause