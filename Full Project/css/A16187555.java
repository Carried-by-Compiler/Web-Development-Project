import java.util.*;
import java.io.*;
import java.lang.*;

//Ben O'Brien
public class A16187555
{
	public static void main(String [] args) throws IOException
	{
		boolean validInput = false;
		String filename = "";
		//Scanner in = new Scanner(System.in);
		String filePattern1 = "[A-Za-z0-9].csv";
		String filePattern2 = "[A-Za-z0-9].txt";
		File aFile = new File("");
		
		if(args[0] == "")
			System.out.println("Enter a valid command line argument");
		else
		{
			filename = args[0];
			filename = filename.toLowerCase();
			aFile = new File(filename);
		}
		if(args.length > 1)
			System.out.println("Too many arguments.");
		
		else if(!(filename.matches(filePattern1) || filename.matches(filePattern2)))
			System.out.println("Invalid Format Please Try again.");
		
		else if(!(aFile.exists()))
			System.out.println("File does not exist");
		else
		{	
			Scanner in = new Scanner(aFile);
			if(in.nextLine().equals(""))
				System.out.println("File is empty");
			else
				validInput = true;
		}
		
		if(validInput)
			checkCellReferenceType(filename);
		
			
	}
	
	public static void checkCellReferenceType(String input)
	{
		File aFile = new File(filename);
		Scanner in = new Scanner(aFile);
		String tempCode = "";
		boolean valid = false;
		String patternRelative 		= "[A-Z]{1,2,3}[0-9]{1,2,3,4,5,6,7}";
		String patternAbsolute 		= "$[A-Z]{1,2,3}$[0-9]{1,2,3,4,5,6,7}";
		String patternColumAbsolute = "[A-Z]{1,2,3}$[0-9]{1,2,3,4,5,6,7}";
		String patternRowAbsolute 	= "$[A-Z]{1,2,3}[0-9]{1,2,3,4,5,6,7}";
		while(in.hasNext())
		{
			tempCode = in.nextLine();
			if(tempCode.matches(patternRelative))
				tempCode += "\t\t " + tempCode + " is RELATIVE ";
			else if(tempCode.matches(patternAbsolute))
				tempCode += "\t\t" + tempCode + " is ABSOLUTE";
			else if(tempCode.matches(patternColumAbsolute))
				tempCode += "\t\t" + tempCode + " is COLUMN ABSOLUTE";
			else if(tempCode.matches(patternRowAbsolute))
				tempCode += "\t\t" + tempCode + " is ROW ABSOLUTE";
			else
				tempCode += "\t\t" + tempCode + " Is Invalid";
			
			System.out.println(tempCode);
		}
	}
}