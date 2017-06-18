rem 䠩� ��� ��娢�஢���� ����� ᠩ� � 䠩� ��娢� � ����� �ய����
rem ������ ��室����� � ��୥ ᠩ�
echo ----------- START BACKUP -------------
echo off
rem 1) 㪧��뢠�� �����, ��� ��室���� WinRAR
set winrarDir=C:\Program Files\WinRAR
rem 2) 㪧��뢠�� �����, ��� �㤥� ��࠭����� ��娢
set dirtosave=C:\Users\sanzhar.ismailov\Dropbox\Sanzhar\php\PUBL\�����ୠ�
rem 3) 㪧��뢠�� ����� � 䠩��� �� ��娢��㥬�� 䠩���
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