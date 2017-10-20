SELECT tax_id, name_txt, name_class
FROM ncbi_names
INTO OUTFILE '/tmp/ncbi_names.txt' FIELDS TERMINATED BY "\t";